# Torque Careers

Registers two CPTs:

1.  Careers - a public CPT allowing the user to post job openings, and allowing the theme to display them in a loop.
2.  Job Applicatons - a private CPT for storing submitted job applications in the db. This comes with a class exposing an interface for saving and finding the job applications in the db.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_careers_job_application_public` | Make job application CPT public | bool (false)

<!-- prettier-ignore-end -->

# Changelog

## [1.1.0] 04/03/2019

### Added

- Filter for making Job Applications CPT public

## [1.0.0]

### Added

- Add Careers CPT
- Add Job Applications CPT with save application interface.
