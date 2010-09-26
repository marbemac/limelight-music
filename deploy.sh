# running this file will deploy the current code to production

# put up the under construction page
echo 'going down for maintenance'
cd /srv/www/limelight
php symfony project:disable frontend

# deploy
echo 'deploying...'
cd /srv/www/staging/limelight
php symfony project:deploy production --go

# update DB
echo 'updating the database'
cd /srv/www/limelight
php symfony doctrine:generate-migrations-diff --env=prod
php symfony doctrine:build --all-classes --and-migrate --env=prod

# make sure only productoin controllers are there
echo 'delete all but production controllers'
php symfony project:clear-controllers

# fix permissions
echo 'fixing permissions...'
php symfony project:permissions

# put the site back online
echo 'putting site back online...'
php symfony project:enable frontend