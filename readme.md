# Uvel

A jewelry e-commerce platform built with Laravel.

## Technical Stack

- **PHP**: 8.3
- **Database**: MariaDB 10.6.18-MariaDB
- **Database Name**: uvelbgrk_prod

## Installation

Get started with these simple steps:

```bash
bash ./prerequisites.sh
bash make setup
bash make up
```

## Deployment

### Asset Management

Assets should be committed to the `public__PHYSICAL` folder by developers. During deployment, copy these assets to the actual symlink location.

**Example - Updating stylesheets:**
```bash
cp ~/new.uvel.bg/public__PHYSICAL/store/stylesheets/store.css ~/public_html/store/stylesheets/
```

> **Note**: Ensure all asset changes are properly tested before deployment to maintain site functionality.