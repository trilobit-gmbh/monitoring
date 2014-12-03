=============================
Contao Extension "Monitoring"
=============================

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