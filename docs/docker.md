# Torque WP Docker Environment

This idea is for us to have a very easy to set up WP environment which both clients and devs
will also be able to run locally on their own machines, with identical environments,
needing only to install docker.

## Key Docker Terms

- Image:
  A container is launched by running an image. An image is an executable package that includes everything needed to run an application - the code, a runtime, libraries, environment variables, and configuration files.

- Container:
  A container is a runtime instance of an image - what the image becomes in memory when executed (that is, an image with state, or a user process). You can see a list of your running containers with the command, `docker ps`, just as you would in Linux.

## Usage

#### Setup

- Follow steps in [setup](./setup.md) to get your docker containers up and running.

- Visit http://localhost:8000 to view the site, or to complete the 5 minute installation
  if this is a new project.

#### Databse

- Visit http://localhost:8080 to open phpmyadmin. You can do everything you want here as you normally would on a MAMP installation (import/export tables, manage users etc).

- The db data is stored as a volume ([see Docker Volumes](#resources)), meaning it actually lives on your local machine, not within the container, and docker just has its own access to it.
  This gives us the ability to safely restart the mysql container without losing anything. See below for more info.

#### Updating WP-Content

- wp-content is stored as a bind mount ([see Docker Volumes](#resources)), so effectively it will stay in sync inside and outside the container. It actually lives outside the container (in the project root), so deleting the container or the image won't affect it.

- Since wp-content is a volume, we can make changes to it either manually or via Wordpress (eg by installing a plugin) and it will always stay in sync.

_**Beware:**_ Reinstalling or updating the wp core could overwrite wp-content.
Make sure you have it backed up and saved in a different location before running
anything that will affect the wp core. This is why we work on the the files in a separate src dir and have webpack copy them over.

### Notice

_You can close and restart docker and the containers, and the database will persist.
Running_

```sh
$ docker-compose down --volumes
```

_**will remove the database.**_

_Next time you start the container it will build a completely new one_

## Resources

- Docker overview: https://docs.docker.com/engine/docker-overview/#docker-engine
- Wordpress Docker Image: https://hub.docker.com/_/wordpress/
- MySQL Docker Image: https://hub.docker.com/_/mysql/
- Docker Volumes: https://docs.docker.com/storage/volumes/
- Deployment: http://www.chris-kelly.net/2016/08/04/docker-meet-wordpress-a-production-deploy-for-the-average-person/
