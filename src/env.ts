import 'dotenv/config';

class Env {
    constructor() {
        const envVariablesNames = [
            'HTTP_PORT',
            'NODE_ENV',
            'REDIS_HOST',
            'REDIS_PORT',
        ];

        for (let i = 0; i < envVariablesNames.length; i++) {
            const envVariableName = envVariablesNames[i];
            if (!process.env[envVariableName]) {
                console.error(`Please set ${envVariableName} env variable`);
                process.exit(1) as string;
            }
        }
    }
    getHttpPort() {
        return process.env.HTTP_PORT as string;
    }
    getNodeEnv() {
        return process.env.NODE_ENV as string;
    }

    getRedisHost() {
        return process.env.REDIS_HOST as string;
    }
    getRedisPort() {
        return process.env.REDIS_PORT as string;
    }
}

export const env = new Env();
