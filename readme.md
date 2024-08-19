# Uvel

- PHP Version: 7.3
- Database: MariaDB 10.6.18-MariaDB
- Database name: uvelbgrk_prod

## Installation steps

```bash
docker compose up -d
docker exec -it uvel-app bash -c "composer run-script post-root-package-install"
docker exec -it uvel-app bash -c "composer install"
```
