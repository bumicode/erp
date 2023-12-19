# Use an official Node runtime as a parent image
FROM node:16.17.0-bullseye-slim

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY .env.example .env
COPY . .

# Install dependencies
RUN apt-get update -y && \
    apt-get install -y --no-install-recommends software-properties-common gnupg2 wget && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list && \
    wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - && \
    apt-get update -y && \
    apt-get install -y --no-install-recommends php8.1 php8.1-curl php8.1-xml php8.1-zip php8.1-gd php8.1-mbstring php8.1-mysql && \
    apt-get update -y && \
    apt-get --no-install-recommends install -y composer && \
    composer update && \
    composer install && \
    npm install --ignore-scripts && \
    php artisan key:generate && \
    rm -rf /var/lib/apt/lists/* && \
    useradd -ms /bin/bash appuser

# Change to the non-root user
USER appuser

# CMD specifies the command to run on container start
CMD ["bash", "./run.sh"]
