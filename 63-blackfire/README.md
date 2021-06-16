# Blackfire

## Setup

- Create `.env.docker` file with [your Blackfire credentials](https://blackfire.io/docs/up-and-running/docker):
    ```dotenv
    # .env.docker
    BLACKFIRE_SERVER_ID=7b92bac0-3b5a-4597-9ad6-488298696a7f
    BLACKFIRE_SERVER_TOKEN=a2287046c6adb51b5b22cbadae198509aebe77b7ccfad80e55010ecbd7e4bb3a
    BLACKFIRE_CLIENT_ID=7f29d398-9cf8-49d8-b1aa-4c62a9973478
    BLACKFIRE_CLIENT_TOKEN=7d869162ebdfd54dd29c09505db8066d3acf7363abe3b8d1d05373b66ec2ab1c
    ```
- Run `make start` to initialize de web server
- Execute Blackfire with `docker-compose exec blackfire blackfire curl http://php:8000/`
