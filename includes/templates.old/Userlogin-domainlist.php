<?php

/*
 * gc.ca common domain list
 *
 * for Userlogin.php email selector
 */

$domainList = Array(
	/********************/
	'institution.gc.ca', # IMPORTANT : first key needs to be an example or empty string (i.e. it will not be a valid option)
	/*******************/
	
	#'aac',
	#'aac-aafc',
	#'aafc',
	#'aafc-aac',
	'acdi-cida',
	'acoa-apeca',
	'agr',
	'ainc-inac',
	'asc-csa',
	'bnet.pco',
	'bnet.pco-bcp',
	#'cas-satj',
	#'catsa',
	'cbsa-asfc',
	'ceaa', //low
	'cic',
	#'cihr',
	#'cihr-irsc',
	'cnsc-ccsn',
	'cpsa', //low
	'cpsa-afpc',
	'cra-arc',
	'cse-cst',
	'csps-efpc',
	'dec-ced',
	'dfo-mpo',
	'drdc-rddc', //low
	'ec',
	'fin',
	#'fintrac.gc',
	'fintrac-canafe', //semi-low
	'forces',
	'hc-sc',
	'hrsdc-rhdsc',
	'ic',
	'inac',
	'inac-ainc', //low
	'infc',
	'international',
	'inspection',
	#'irb-cisr',
	'justice',
	'lac-bac',
	#'mar.dfo-mpo',
	'neb-one', //low
	'nrcan',
	'nrcan-rncan',
	'nrc-cnrc',
	#'ocol-clo',
	#'ofc-cfo', //very low
	'parl',
	'pc',
	'pch',
	'phac-aspc',
	'pptc',
	'ps',
	'ps-sp',
	'psc-cfp',
	'pwgsc',
	'pwgsc-tpsgc',
	'rcmp-grc',
	#'rncan-nrcan',
	'scc-csc', //low
	'sen.parl', //low
	'servicecanada',
	'smtp', //low
	#'sp', //very low
	'statcan',
	#'tbs', //none
	'tbs-sct',
	'tc',
	'tpsgc',
	'tpsgc-pwgsc',
	'vac-acc',
	'wd',
	'wd-deo', //low


);

# for testing:
//echo sizeof($domainList);

?>

