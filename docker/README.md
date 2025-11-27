# Docker Instructions

## Prerequisites
- Docker and Docker Compose installed.

## How to Run

1.  Navigate to the `docker` directory:
    ```bash
    cd docker
    ```

2.  Build and start the containers:
    ```bash
    docker-compose up -d --build
    ```

3.  Access the application:
    Open your browser and go to [http://localhost:8080](http://localhost:8080).

## Database
- The database is automatically initialized with the `database/career_guidance_db.sql` file.
- **Host**: `db`
- **Port**: `3306` (Internal), `3307` (External)
- **User**: `root`
- **Password**: `rootpassword`
- **Database**: `career_guidance_db`

## Stopping the Application
To stop the containers:
```bash
docker-compose down
```
