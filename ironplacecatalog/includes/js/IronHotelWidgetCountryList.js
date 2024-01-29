const countries = [
    ["Select country", ""],
    ["Afghanistan", "AF"],
    ["Åland", "AX"],
    ["Albania", "AL"],
    ["Algeria", "DZ"],
    ["American Samoa", "AS"],
    ["Andorra", "AD"],
    ["Angola", "AO"],
    ["Anguilla", "AI"],
    ["Antarctica", "AQ"],
    ["Antigua and Barbuda", "AG"],
    ["Argentina", "AR"],
    ["Armenia", "AM"],
    ["Aruba", "AW"],
    ["Australia", "AU"],
    ["Austria", "AT"],
    ["Azerbaijan", "AZ"],
    ["Bahamas", "BS"],
    ["Bahrain", "BH"],
    ["Bangladesh", "BD"],
    ["Barbados", "BB"],
    ["Belarus", "BY"],
    ["Belgium", "BE"],
    ["Belize", "BZ"],
    ["Benin", "BJ"],
    ["Bermuda", "BM"],
    ["Bhutan", "BT"],
    ["Bolivia", "BO"],
    ["Bonaire, Sint Eustatius and Saba", "BQ"],
    ["Bosnia and Herzegovina", "BA"],
    ["Botswana", "BW"],
    ["Bouvet Island", "BV"],
    ["Brazil", "BR"],
    ["British Indian Ocean Territory", "IO"],
    ["Brunei Darussalam", "BN"],
    ["Bulgaria", "BG"],
    ["Burkina Faso", "BF"],
    ["Burundi", "BI"],
    ["Cambodia", "KH"],
    ["Cameroon", "CM"],
    ["Canada", "CA"],
    ["Cape Verde", "CV"],
    ["Cayman Islands", "KY"],
    ["Central African Republic", "CF"],
    ["Chad", "TD"],
    ["Chile", "CL"],
    ["China", "CN"],
    ["Christmas Island", "CX"],
    ["Cocos (Keeling) Islands", "CC"],
    ["Colombia", "CO"],
    ["Comoros", "KM"],
    ["Congo (Brazzaville)", "CG"],
    ["Congo (Kinshasa)", "CD"],
    ["Cook Islands", "CK"],
    ["Costa Rica", "CR"],
    ["Côte d'Ivoire", "CI"],
    ["Croatia", "HR"],
    ["Cuba", "CU"],
    ["Curaçao", "CW"],
    ["Cyprus", "CY"],
    ["Czech Republic", "CZ"],
    ["Denmark", "DK"],
    ["Djibouti", "DJ"],
    ["Dominica", "DM"],
    ["Dominican Republic", "DO"],
    ["Ecuador", "EC"],
    ["Egypt", "EG"],
    ["El Salvador", "SV"],
    ["Equatorial Guinea", "GQ"],
    ["Eritrea", "ER"],
    ["Estonia", "EE"],
    ["Ethiopia", "ET"],
    ["Falkland Islands", "FK"],
    ["Faroe Islands", "FO"],
    ["Fiji", "FJ"],
    ["Finland", "FI"],
    ["France", "FR"],
    ["French Guiana", "GF"],
    ["French Polynesia", "PF"],
    ["French Southern Lands", "TF"],
    ["Gabon", "GA"],
    ["Gambia", "GM"],
    ["Georgia", "GE"],
    ["Germany", "DE"],
    ["Ghana", "GH"],
    ["Gibraltar", "GI"],
    ["Greece", "GR"],
    ["Greenland", "GL"],
    ["Grenada", "GD"],
    ["Guadeloupe", "GP"],
    ["Guam", "GU"],
    ["Guatemala", "GT"],
    ["Guernsey", "GG"],
    ["Guinea", "GN"],
    ["Guinea-Bissau", "GW"],
    ["Guyana", "GY"],
    ["Haiti", "HT"],
    ["Heard and McDonald Islands", "HM"],
    ["Honduras", "HN"],
    ["Hong Kong", "HK"],
    ["Hungary", "HU"],
    ["Iceland", "IS"],
    ["India", "IN"],
    ["Indonesia", "ID"],
    ["Iran", "IR"],
    ["Iraq", "IQ"],
    ["Ireland", "IE"],
    ["Isle of Man", "IM"],
    ["Israel", "IL"],
    ["Italy", "IT"],
    ["Jamaica", "JM"],
    ["Japan", "JP"],
    ["Jersey", "JE"],
    ["Jordan", "JO"],
    ["Kazakhstan", "KZ"],
    ["Kenya", "KE"],
    ["Kiribati", "KI"],
    ["Korea, North", "KP"],
    ["Korea, South", "KR"],
    ["Kuwait", "KW"],
    ["Kyrgyzstan", "KG"],
    ["Laos", "LA"],
    ["Latvia", "LV"],
    ["Lebanon", "LB"],
    ["Lesotho", "LS"],
    ["Liberia", "LR"],
    ["Libya", "LY"],
    ["Liechtenstein", "LI"],
    ["Lithuania", "LT"],
    ["Luxembourg", "LU"],
    ["Macau", "MO"],
    ["Macedonia", "MK"],
    ["Madagascar", "MG"],
    ["Malawi", "MW"],
    ["Malaysia", "MY"],
    ["Maldives", "MV"],
    ["Mali", "ML"],
    ["Malta", "MT"],
    ["Marshall Islands", "MH"],
    ["Martinique", "MQ"],
    ["Mauritania", "MR"],
    ["Mauritius", "MU"],
    ["Mayotte", "YT"],
    ["Mexico", "MX"],
    ["Micronesia", "FM"],
    ["Moldova", "MD"],
    ["Monaco", "MC"],
    ["Mongolia", "MN"],
    ["Montenegro", "ME"],
    ["Montserrat", "MS"],
    ["Morocco", "MA"],
    ["Mozambique", "MZ"],
    ["Myanmar", "MM"],
    ["Namibia", "NA"],
    ["Nauru", "NR"],
    ["Nepal", "NP"],
    ["Netherlands", "NL"],
    ["New Caledonia", "NC"],
    ["New Zealand", "NZ"],
    ["Nicaragua", "NI"],
    ["Niger", "NE"],
    ["Nigeria", "NG"],
    ["Niue", "NU"],
    ["Norfolk Island", "NF"],
    ["Northern Mariana Islands", "MP"],
    ["Norway", "NO"],
    ["Oman", "OM"],
    ["Pakistan", "PK"],
    ["Palau", "PW"],
    ["Palestine", "PS"],
    ["Panama", "PA"],
    ["Papua New Guinea", "PG"],
    ["Paraguay", "PY"],
    ["Peru", "PE"],
    ["Philippines", "PH"],
    ["Pitcairn", "PN"],
    ["Poland", "PL"],
    ["Portugal", "PT"],
    ["Puerto Rico", "PR"],
    ["Qatar", "QA"],
    ["Reunion", "RE"],
    ["Romania", "RO"],
    ["Russian Federation", "RU"],
    ["Rwanda", "RW"],
    ["Saint Barthélemy", "BL"],
    ["Saint Helena", "SH"],
    ["Saint Kitts and Nevis", "KN"],
    ["Saint Lucia", "LC"],
    ["Saint Martin (French part)", "MF"],
    ["Saint Pierre and Miquelon", "PM"],
    ["Saint Vincent and the Grenadines", "VC"],
    ["Samoa", "WS"],
    ["San Marino", "SM"],
    ["Sao Tome and Principe", "ST"],
    ["Saudi Arabia", "SA"],
    ["Senegal", "SN"],
    ["Serbia", "RS"],
    ["Seychelles", "SC"],
    ["Sierra Leone", "SL"],
    ["Singapore", "SG"],
    ["Sint Maarten", "SX"],
    ["Slovakia", "SK"],
    ["Slovenia", "SI"],
    ["Solomon Islands", "SB"],
    ["Somalia", "SO"],
    ["South Africa", "ZA"],
    ["South Georgia and South Sandwich Islands", "GS"],
    ["South Sudan", "SS"],
    ["Spain", "ES"],
    ["Sri Lanka", "LK"],
    ["Sudan", "SD"],
    ["Suriname", "SR"],
    ["Svalbard and Jan Mayen Islands", "SJ"],
    ["Swaziland", "SZ"],
    ["Sweden", "SE"],
    ["Switzerland", "CH"],
    ["Syria", "SY"],
    ["Taiwan", "TW"],
    ["Tajikistan", "TJ"],
    ["Tanzania", "TZ"],
    ["Thailand", "TH"],
    ["Timor-Leste", "TL"],
    ["Togo", "TG"],
    ["Tokelau", "TK"],
    ["Tonga", "TO"],
    ["Trinidad and Tobago", "TT"],
    ["Tunisia", "TN"],
    ["Turkey", "TR"],
    ["Turkmenistan", "TM"],
    ["Turks and Caicos Islands", "TC"],
    ["Tuvalu", "TV"],
    ["Uganda", "UG"],
    ["Ukraine", "UA"],
    ["United Arab Emirates", "AE"],
    ["United Kingdom", "GB"],
    ["United States Minor Outlying Islands", "UM"],
    ["United States of America", "US"],
    ["Uruguay", "UY"],
    ["Uzbekistan", "UZ"],
    ["Vanuatu", "VU"],
    ["Vatican City", "VA"],
    ["Venezuela", "VE"],
    ["Vietnam", "VN"],
    ["Virgin Islands, British", "VG"],
    ["Virgin Islands, U.S.", "VI"],
    ["Wallis and Futuna Islands", "WF"],
    ["Western Sahara", "EH"],
    ["Yemen", "YE"],
    ["Zambia", "ZM"],
    ["Zimbabwe", "ZW"]
];