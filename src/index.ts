import { env } from "./env"
import { createServer } from 'http';
import express from 'express';
import { Server } from 'socket.io';
import { createAdapter } from '@socket.io/redis-adapter';
import { createClient } from 'redis';

const app = express();
const httpServer = createServer(app);
/**
 * create server
 */
const io = new Server(httpServer, {
    cors: {
        origin: '*',
    },
});

/**
 * establish redis connection
 */
const publishClient = createClient({
    url: `redis://:@${env.getRedisHost()}:${env.getRedisPort()}`,
});
/**
 * handle connection error
 */
publishClient.on('error', (error) => {
    console.error('Unable to connect to Redis (socket.io publish client)', error);
});
/**
 * connection success
 */
publishClient.connect().then(() => {
    console.log('Redis (socket.io publish client) connection has been established successfully');
});

io.on('connection', async (socket) => {
    /**
     * connected user data to save in DB
     */
    const user = {
        socketId: socket.id,
        user_id: +(socket.handshake?.headers?.user_id || -1),
        status: 'online'
    }
    /**
     * clone sub instance from publisher
     */
    const subscribeClient = publishClient.duplicate();

    /**
     *  handle subs error
     */
    subscribeClient.on('error', (error) => {
        console.error('Unable to connect to Redis (socket.io subscribe client)', error);
    });
    subscribeClient.connect().then(() => {
        console.log('Redis (socket.io subscribe client) connection has been established successfully');
    });
    /**
     * publish connected user data
     */
    publishClient.publish("chat_userConnected", JSON.stringify(user));

    /**
     * fire messages via socket
     */
    subscribeClient.subscribe('chat_message', (payload, channel) => {
        const res = JSON.parse(payload);
        const { message, socketId } = res.data
        if (socketId) {
            socket.send(message);

        }
    })
    /**
     * init sub & publisher
     */
    io.adapter(createAdapter(publishClient, subscribeClient));
    /**
     * handel disconnection
     */
    socket.on("disconnect", async () => {
        try {
            user.status = 'offline';
            user.socketId = '';
            publishClient.publish("chat_userConnected", JSON.stringify(user));
            subscribeClient.quit();
        } catch (err) {
            console.log(err)
        }

    })
});

const port = env.getHttpPort();
httpServer.listen(port, () => {
    console.log(`Server started at http://localhost:${port}`);
});
