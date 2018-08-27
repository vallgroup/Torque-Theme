# TORQUE THEME 1.1.0

Created by Torque

## Docs

- [Setup](./docs/setup.md)
- [Developing](./docs/developing.md)
- [Torque Docker README](./docs/docker.md)

## CLI

> Please read Setup docs before using these commands

```sh
$ yarn setup
```

See setup docs... sets up the dev environment

```sh
$ yarn rebuild
```

Resets wp-content and uploads.
It's recommended to always run this after fetching new commits from remote.

```sh
$ yarn start <optional workspace arg>
```

Prepares and starts server, bundler and watcher for a workspace.
Can pass the workspace name to the command, otherwise you will be prompted for it in the shell.

```sh
$ yarn switch <optional git branch name arg>
```

**Important:** Always use this instead of `git checkout`
Safely closes current dev environment and switches to another.
If no branch name is passed as an argument then you will prompted for it in the shell.

```sh
$ yarn uploads <optional from_repo|from_wp_content>
```

You can use this to keep uploads up to date between wp-content and the repo.

Args:

- none: Passing no argument will copy uploads from wp-content to repo so they can be committed and saved.
- from_repo: Copies uploads from repo to wp-content
- from_wp_content: Copies uploads from wp-content to repo

```sh
$ yarn logs:php
$ yarn logs:mysql
```

Get a live output of the logs in the shell from php and mysql respectively.

## Resources

- [Changelog](./docs/changelog.md)
