#!/bin/bash
 
# prerequisites.sh
# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[0;33m'
NC='\033[0m'

# Logging functions
log() { echo -e "${BLUE}[INFO]${NC} $1"; }
warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
error() { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }
success() { echo -e "${GREEN}[SUCCESS]${NC} $1"; }

 
# Check if docker is installed
check_docker() {
    if ! command -v docker &> /dev/null; then
        error "Error: Docker is not installed. Please install Docker to proceed."
        exit 1
    fi

    log "Docker is installed on this system"
}

is_docker_running() {
    docker info > /dev/null 2>&1

    # Ensure that Docker is running...
    if [ $? -ne 0 ]; then
        error "Error: Docker is not running."
        exit 1
    fi

    log "Docker is running on this system"
}

docker_version() {
    log "$(docker --version)"
}

verify_installations() {
    log "Verifying installations..."
    
    REQUIRED_COMMANDS=(
        "docker"
        "make"
        "git"
    )
    
    for cmd in "${REQUIRED_COMMANDS[@]}"; do
        if ! command -v "$cmd" &>/dev/null; then
            error "$cmd is not properly installed"
        fi
    done
    
    success "All required tools are installed"
}

configure_env() {
    if [ ! -f .env ]; then
        if [ -f .env.example ]; then
            cp .env.example .env
            success ".env file created from .env.example"
        else
            error ".env.example file not found. Unable to create .env file."
        fi
    else
        warn ".env file already exists, skipping creation."
    fi
}


main() {
    echo -e "${GREEN}"
    echo "╔════════════════════════════════════════╗"
    echo "║    Prerequisites RubberDuck Script     ║"
    echo "║    for Application Development Env     ║"
    echo "╚════════════════════════════════════════╝"
    echo -e "${NC}"

    verify_installations
    docker_version
    is_docker_running
    configure_env

    echo -e "${GREEN}"
    echo "╔════════════════════════════════════════╗"
    echo "║    Prerequisites script                ║"
    echo "║    completed successfully!             ║"
    echo "║                                        ║"
    echo "║    Please run make setup next          ║"
    echo "╚════════════════════════════════════════╝"
    echo -e "${NC}"
}

main "$@"