<?php

/**
 * Utility class to perform various actions across the whole system
 *
 * @Date: $Date$
 */
class Utils
{
	/**
	 * Method to upload any file.
	 *
	 * @param array $extensions Array of allowed extensions file for the uploading media.
	 * @param file $fichier The uploaded file.
	 * @param string $module The module to upload the file. Defines the final subdirectory into the upload folder.
	 *
	 * @return mixed If upload is correctly done, returns the file name to save into the database.
	 */
	public static function upload($extensions, $fichier, $module)
	{
		$file_name = $fichier['name'];
		$file_size = $fichier['size'];
		$file_tmp = $fichier['tmp_name'];
		$file_ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
		$path = str_replace('/admin/..', '', DIR);

		$pattern = "/^[\p{L}\w\s\-\.]{3,}$/";

		if (!preg_match($pattern, $file_name))
		{
			throw new Exception('Le nom de fichier n\'est pas valide.');
		}

		if (!in_array($file_ext, $extensions))
		{
			throw new Exception('L\'extension n\'est pas autorisée.');
		}

		$maxupload = ini_get('upload_max_filesize');

		if ($file_size > self::return_bytes($maxupload))
		{
			throw new Exception('La taille du fichier ne doit pas dépasser ' . self::return_bytes($maxupload) . '.');
		}

		$file_name = substr(md5($fichier['name']), 10) . '.' . $file_ext;

		while (file_exists($path . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $file_name))
		{
			$file_name = substr(md5($file_name), 10) . '.' . $file_ext;
		}

		$targetFile =  $path . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $file_name;

		if (move_uploaded_file($file_tmp, $targetFile))
		{
			return $file_name;
		}
		else
		{
			throw new Exception('Echec de l\'upload.');
		}
	}

	/**
	 * Converts a size data into full size.
	 *
	 * This allows to convert a value like 3M to 3145728.
	 *
	 * @param string $val Value to convert.
	 *
	 * @return integer Value converted in full length.
	 */
	private static function return_bytes($val)
	{
		$val = trim($val);
		$last = strtolower($val[strlen($val) - 1]);

		switch($last)
		{
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}

	/**
	 * Verifies if the input value uses a correct format.
	 *
	 * @param string $str Value to verify.
	 * @param string $type Type of value to verify.
	 *
	 * @return string Error message to display into a try/catch.
	 */
	public static function datavalidation($str, $type)
	{
		$str = trim(strip_tags((string)$str));

		$tabRegex = [
		  "test" => '/[\w]123/',
		  "nom" => "/^[\p{L}\s]{2,}$/u",
		  "prenom" => "/^[\p{L}\s]{2,}$/u",
		  "tel" => "/^[\+]?[0-9]{10}$/",
		  "photo" => "/^[\w\s\-\.]{1,22}(.jpg|.jpeg|.png|.gif)$/",
		  "id" => "/[\d]+/"

		];

		switch ($type)
		{
			case "email":
				if (!filter_var($str, FILTER_VALIDATE_EMAIL))
				{
					$return = 'Le champ \'Adresse email\' n\'est pas valide.';
				}
				break;
			case "url":
				if (!filter_var($str, FILTER_VALIDATE_URL))
				{
					$return = 'Le champ \'URL\' n\'est pas valide.';
				}
				break;
			default:
				if (!preg_match($tabRegex[$type], $str))
				{
					$return = 'Le champ \'' . $type . '\' n\'est pas au format demandé.';
				}
		}

		return $return;
	}

	/**
	 * Verifies if the permission id is in the array of values in $_SESSION.
	 *
	 * @param integer $pid Permission ID found in table 'permission'.
	 *
	 * @return boolean True if found (allow the user), false if not found (disallow the user)
	 */
	public static function cando($pid)
	{
		return in_array($pid, $_SESSION['employee']['permissions']);
	}

	/**
	 * Returns an array of values passed through print_r with some formatting. Useful to debug arrays.
	 *
	 * @param array $value Array of values to debug.
	 * @param boolean $exit Do we stop the script process just after its execution?
	 *
	 * @return voir
	 */
	public static function printr($value, $exit = 0)
	{
		echo '<div><pre>';
		print_r($value);
		echo '</pre></div>';

		if ($exit == 1)
		{
			exit;
		}
	}

	/**
	 * Creates a list of countries to display in the customer profile. Not used actually, maybe added later.
	 *
	 * @param string $selected Value stored in the database for the customer.
	 *
	 * @return string Returns  string with all values stored in &lt;option> tags
	 */
	public static function createCountryList($selected = '')
	{
		$return = '';

		$countries = [
			'AF' => 'Afghanistan', 'ZA' => 'Afrique du Sud', 'AL' => 'Albanie', 'DZ' => 'Algérie', 'AD' => 'Andorre', 'AO' => 'Angola',
			'AI' => 'Anguilla', 'DE' => 'Allemagne', 'AQ' => 'Antarctique', 'AG' => 'Antigua-et-Barbuda', 'SA' => 'Arabie saoudite',
			'AR' => 'Argentine', 'AM' => 'Arménie', 'AW' => 'Aruba', 'AU' => 'Australie', 'AT' => 'Autriche', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas',
			'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbade', 'BE' => 'Belgique', 'BZ' => 'Bélize', 'BJ' => 'Bénin', 'BM' => 'Bermudes',
			'BT' => 'Bhoutan', 'BY' => 'Biélorussie', 'BO' => 'Bolivie', 'BA' => 'Bosnie Herzégovine', 'BW' => 'Botswana', 'BR' => 'Brésil',
			'BN' => 'Brunei Darussalam', 'BG' => 'Bulgarie', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodge', 'CM' => 'Cameroun',
			'CA' => 'Canada', 'CV' => 'Cap Vert', 'VA' => 'Cité du Vatican', 'CL' => 'Chili', 'CN' => 'Chine', 'CO' => 'Colombie', 'KM' => 'Comores',
			'CG' => 'Congo - Brazzaville', 'CD' => 'Congo - Kinshasa', 'CR' => 'Costa Rica', 'KP' => 'Corée du Nord', 'KR' => 'Corée du Sud',
			'CI' => 'Côte d’Ivoire', 'HR' => 'Croatie', 'CU' => 'Cuba', 'CY' => 'Chypre', 'DK' => 'Danemark', 'DJ' => 'Djibouti', 'DM' => 'Dominique',
			'EG' => 'Egypte', 'SV' => 'El Salvador', 'AE' => 'Émirats arabes unis', 'EC' => 'Équateur', 'ER' => 'Érythrée', 'ES' => 'Espagne',
			'EE' => 'Estonie', 'SZ' => 'Eswatini', 'US' => 'États-Unis', 'ET' => 'Ethiopie', 'FJ' => 'Fidji', 'FI' => 'Finlande', 'FR' => 'France',
			'GA' => 'Gabon', 'GM' => 'Gambie', 'GE' => 'Géorgie', 'GS' => 'Géorgie du Sud et les Îles Sandwich du Sud', 'GH' => 'Ghana',
			'GI' => 'Gibraltar', 'GR' => 'Grèce', 'GD' => 'Grenade', 'GL' => 'Groenland', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala',
			'GG' => 'Guernesey', 'GN' => 'Guinée', 'GQ' => 'Guinée équatoriale', 'GW' => 'Guinée-Bissau', 'GY' => 'Guyane', 'GF' => 'Guyane française',
			'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hongrie', 'BV' => 'Île Bouvet', 'CX' => 'Île Christmas',
			'IM' => 'Île de Man', 'NF' => 'Île Norfolk', 'AX' => 'Îles Åland', 'KY' => 'Îles Caïmans', 'CC' => 'Îles Cocos (Keeling)', 'CK' => 'Îles Cook',
			'FK' => 'Îles Falkland (Malvinas)', 'FO' => 'Îles Féroé', 'HM' => 'Îles Heard et McDonald', 'MP' => 'Îles Mariannes du Nord',
			'MH' => 'Îles Marshall', 'UM' => 'Îles mineures éloignées des États-Unis', 'PN' => 'Îles Pitcairn', 'SB' => 'Îles Salomon',
			'TC' => 'Îles Turks et Caïques', 'VG' => 'Îles Vierges britanniques', 'VI' => 'Îles Vierges des États-Unis', 'IN' => 'Inde',
			'ID' => 'Indonésie', 'IR' => 'Iran', 'IQ' => 'Irak', 'IE' => 'Irlande', 'IS' => 'Islande', 'IL' => 'Israël', 'IT' => 'Italie',
			'JM' => 'Jamaïque', 'JP' => 'Japon', 'JE' => 'Jersey', 'JO' => 'Jordanie', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati',
			'KW' => 'Koweit', 'KG' => 'Kirghizistan', 'LA' => 'Laos', 'LS' => 'Lesotho', 'LV' => 'Lettonie', 'LB' => 'Liban', 'LR' => 'Libéria',
			'LY' => 'Libye', 'LI' => 'Liechtenstein', 'LT' => 'Lituanie', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macédoine du Nord',
			'MG' => 'Madagascar', 'MY' => 'Malaisie', 'MW' => 'Malawi', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malte', 'MQ' => 'Martinique',
			'MU' => 'Maurice', 'MR' => 'Mauritanie', 'YT' => 'Mayotte', 'MX' => 'Mexique', 'FM' => 'Micronésie', 'MD' => 'Moldavie', 'MC' => 'Monaco',
			'MN' => 'Mongolie', 'ME' => 'Monténégro', 'MS' => 'Montserrat', 'MA' => 'Maroc', 'MZ' => 'Mozambique', 'MM' => 'Myanmar (Birmanie)',
			'NA' => 'Namibie', 'NR' => 'Nauru', 'NP' => 'Népal', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niué', 'NO' => 'Norvège',
			'NC' => 'Nouvelle-Calédonie', 'NZ' => 'Nouvelle-Zélande', 'OM' => 'Oman', 'UG' => 'Ouganda', 'UZ' => 'Ouzbékistan', 'PK' => 'Pakistan',
			'PW' => 'Palaos', 'PA' => 'Panama', 'PG' => 'Papouasie Nouvelle Guinée', 'PY' => 'Paraguay', 'NL' => 'Pays-Bas', 'PE' => 'Pérou',
			'PH' => 'Philippines', 'PL' => 'Pologne', 'PF' => 'Polynésie française', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar',
			'CF' => 'République centrafricaine', 'DO' => 'République dominicaine', 'RE' => 'Réunion', 'RO' => 'Roumanie', 'GB' => 'Royaume-Uni',
			'RU' => 'Russie', 'RW' => 'Rwanda', 'EH' => 'Sahara occidental', 'BL' => 'Saint-Barthélemy', 'KN' => 'Saint-Kitts-et-Nevis',
			'MF' => 'Saint-Martin', 'PM' => 'Saint-Pierre-et-Miquelon', 'VC' => 'Saint-Vincent et les Grenadines', 'SH' => 'Sainte-Hélène',
			'LC' => 'Sainte-Lucie', 'WS' => 'Samoa', 'AS' => 'Samoa américaines', 'SM' => 'San Marin', 'ST' => 'Sao Tomé-et-Principe', 'SN' => 'Sénégal',
			'RS' => 'Serbie', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapour', 'SK' => 'Slovaquie', 'SI' => 'Slovénie', 'SO' => 'Somalie',
			'LK' => 'Sri Lanka', 'SD' => 'Soudan', 'SR' => 'Suriname', 'SE' => 'Suède', 'CH' => 'Suisse', 'SJ' => 'Svalbard et Jan Mayen', 'SY' => 'Syrie',
			'TJ' => 'Tadjikistan', 'TW' => 'Taiwan', 'TZ' => 'Tanzanie', 'TD' => 'Tchad', 'CZ' => 'Tchéquie',
			'TF' => 'Terres australes et antarctiques françaises', 'IO' => 'Territoire britannique de l\'océan Indien', 'PS' => 'Territoires palestiniens',
			'TH' => 'Thaïlande', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinité-et-Tobago', 'TN' => 'Tunisie',
			'TM' => 'Turkménistan', 'TR' => 'Turquie', 'TV' => 'Tuvalu', 'UA' => 'Ukraine', 'UY' => 'Uruguay', 'VU' => 'Vanuatu', 'VE' => 'Vénézuela',
			'VN' => 'Vietnam', 'WF' => 'Wallis et Futuna', 'YE' => 'Yémen', 'ZM' => 'Zambie', 'ZW' => 'Zimbabwe'
		];

		foreach ($countries AS $key => $value)
		{
			$return .= '<option value="' . $key . '"' . ($key === $selected ? ' selected' : '') . '>' . $value . '</option>';
		}

		return $return;
	}
}

?>