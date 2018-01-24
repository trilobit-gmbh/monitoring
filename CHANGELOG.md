=============================
Contao Extension "Monitoring"
=============================

Version 1.8.2 (2018-01-25)
--------------------------
- Fix bug when loading language files in Contao 4

Version 1.8.1 (2017-06-28)
--------------------------
- Contao 4 ready

Version 1.8.0 (2017-05-09)
--------------------------
- added response time recording (see #15)
- moved to own backend group
- added `MonitoringTestModel`

Version 1.7.2 (2016-10-25)
--------------------------
- Contao 3.5 ready
- Adjust the code to be compatible with PHP7 (see #13)

Version 1.7.1 (2015-06-16)
--------------------------
- Setting correct composer plugin dependency
- Send special `user agent` to identify monitoring check (needed to avoid counting of visitors)
- Remove trailing comma
- Fixing probleme with sending emails (ERROR status was overwritten)

Version 1.7.0 (2015-03-30)
--------------------------
- added hook to modify test result output
- added `MonitoringModel` with misc functions to get monitoring entries
- added missing translation for toggle button
- added restrictions to tests list (not copyable, not creatable, not sortable)

Version 1.6.0 (2014-12-16)
--------------------------
- refactored some code
- changed some icons
- added check messages
- added toggling of deactivation for monitoring entries
- added status icons

Version 1.5.0 (2014-12-03)
--------------------------
- added hook to format the monitoring list
- changed displaying test results from unordered list to table

Version 1.4.0 (2014-12-01)
--------------------------
- extracted additional fields to a separate package ([contao-monitoring/monitoring-additional-infos](https://packagist.org/packages/contao-monitoring/monitoring-additional-infos))
- added hook to modify header for entries in parent view

Version 1.3.3 (2014-11-13)
--------------------------
- modified status colors
- modified icon

Version 1.3.2 (2014-10-07)
--------------------------
- adding additional info fields (see #3)

Version 1.3.1 (2014-09-30)
--------------------------
- removed creating new entry version after test (see #8)
- added debug mode and messages
- modified various things ind backend views (filter, search, etc.)
- fixed probleme while storing added date

Version 1.3.0 (2014-09-26)
--------------------------
- removed setting monitoring as backend startpage (use BackendCustomStartpage)
- added circular testing for error case (see #2)
- added storing result of each test
- fixed overwritting of added date