<?php
/**
 * http://search.cpan.org/~bobernst/Weather-Com-2.0.0/lib/Weather/Com/Base.pm
 * http://wxdata.weather.com/wxdata/weather/local/FRXX0206?cc=*&unit=m&dayf=2
 * Classe de gestion de la base de donnees (MYSQL)
 * @author laurent HAZARD
 * @copyright 
 * @version 1.0
 */

class wMeteo
{

    /*
     * retourne l'id de la ville/pays
     * @param String de la ville, pays a cherche
     * @return String Resultats
     */     
    public function getCityCode($search)
    {

        $search = explode(',', $search);
        $search = array_map('urlencode', $search);
        $search = implode(',+', $search);

        $dom = new DomDocument;
        $dom->load("http://wxdata.weather.com/wxdata/search/search?where=" . $search);
        
        $elements = $dom->getElementsByTagName('search'); 
        $element = $elements->item(0);
        $enfants = $element->childNodes; 
                
       
        foreach ($enfants as $enfant) {

            if ($enfant->nodeName != "#text") {
                $nom[] = $enfant->nodeValue;
            }

            if ($enfant->nodeType == XML_ELEMENT_NODE) {
                $id[] = $enfant->getAttribute('id');
            }  

        }
        return $id[0];

    }


    /*
     * 
     * @param String de la date en VO
     * @return String date FR
     */  
    static function date_fr($date)
    {
        $date= explode(" ", $date);

        $jourFR = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"); 
        $jourUS = array("Monday", "Tuesday", "Wednesday","Thursday", "Friday", "Saturday","Sunday");        

        $moisFR = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"); 
        $moisUS = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); 
        
        $dateFrancais = str_replace($jourUS, $jourFR, $date[0]);
        $dateFrancais .= " ".$date[2]." ";
        $dateFrancais .= str_replace($moisUS, $moisFR, $date[1]);

        return $dateFrancais;
    }

    public static function to24H($time)
    {
        preg_match('#(\d+)\:(\d+)\s+(AM|PM)?#', $time, $matches);
        
        if ($matches[3] == 'PM')
        {
            $matches[1] += 12;
        }

        return $matches[1] . ':' . $matches[2];
    }

    public static function temps_FR($temps) {
        $tempsFR=strtolower(str_replace(array(" ","/"),"",$temps));
        switch ($tempsFR) {
            case "afewclouds":return "Quelques nuages";break;
            case "amcloudspmsun":return "Nuageux dans la matinée / Soleil dans l'après-midi";break;
            case "amcloudspmsunwind":return "Nuageux dans la matinée / Soleil dans l'après-midi / Vent";break;
            case "amdrizzle":return "Bruine dans la matinée";break;
            case "amfogpmsun":return "Brouillard dans la matinée / Soleil dans l'après-midi";break;
            case "amfogpmclouds":return "Brouillard dans la matinée / Nuageux dans l'après-midi";break;
            case "amlightrain":return "Légère pluie dans la matinée";break;
            case "amlightrainwind":return "Légère pluie dans la matinée / Vent";break;
            case "amlightsnow":return "Légères chutes de neige dans la matinée";break;
            case "amlightsnowwind":return "Légères chutes de neige dans la matinée / Vent";break;
            case "amlightwintrymix":return "Légères précipitations hivernales dans la matinée";break;
            case "amrain":return "Pluie dans la matinée";break;
            case "amrainice":return "Pluie dans la matinée / Glace";break;
            case "amrainsnow":return "Pluie dans la matinée / Neige";break;
            case "amrainsnowwind":return "Pluie dans la matinée / Neige / Vent";break;
            case "amrainsnowshowers":return "Pluie / Chutes de neige dans la matinée";break;
            case "amrainwind":return "Pluie dans la matinée / Vent";break;
            case "amshowers":return "Averses dans la matinée";break;
            case "amshowerswind":return "Averses dans la matinée / Vent";break;
            case "amsnow":return "Neige dans la matinée";break;
            case "amsnowshowers":return "Chutes de neige dans la matinée";break;
            case "amsnowshowerswind":return "Chutes de neige dans la matinée / Vent";break;
            case "amt-storms":return "Orages dans la matinée";break;
            case "amwintrymix":return "Précipitations hivernales dans la matinée";break;
            case "blowingsandandwindy":return "Rafales de sable et Vent";break;
            case "blowingsnow":return "Rafales de neige";break;
            case "clear":return "Ciel dégagé";break;
            case "cloudsearlyclearinglate":return "Nuageux d'abord / éclaircie ensuite";break;
            case "cloudy":return "Nuageux";break;
            case "cloudywind":return "Nuageux / Vent";break;
            case "cloudyandwindy":return "Nuageux et Venteux";break;
            case "driftingsnow":return "Rafales de neige";break;
            case "drizzle":return "Bruine";break;
            case "drizzlefog":return "Bruine / Brouillard";break;
            case "fair":return "Beau";break;
            case "fairandwindy":return "Beau et Venteux";break;
            case "fewshowers":return "Quelques averses";break;
            case "fewshowerswind":return "Quelques averses / Vent";break;
            case "fewsnowshowers":return "Quelques chutes de neige";break;
            case "fewsnowshowerswind":return "Quelques chutes de neige / Vent";break;
            case "flurries":return "Chutes de neige fondante";break;
            case "flurrieswind":return "Chutes de neige fondante / Vent";break;
            case "fog":return "Brouillard";break;
            case "fogclouds":return "Brouillard / Ciel se couvrant";break;
            case "foggy":return "Brouillard";break;
            case "foglate":return "Brouillard";break;
            case "freezingrain":return "Pluie verglaçante";break;
            case "haze":return "Légère brume";break;
            case "heavydrizzle":return "Forte bruine";break;
            case "heavyrain":return "Forte pluie";break;
            case "heavyrainwind":return "Forte pluie / Vent";break;
            case "heavyrainshower":return "Fortes averses";break;
            case "heavyrainshowerandwindy":return "Fortes averses et Vent";break;
            case "heavysnow":return "Fortes chutes de neige";break;
            case "heavyt-storm":return "Orage violent";break;
            case "heavyt-stormandwindy":return "Orage violent et Vent";break;
            case "heavyt-storms":return "Orages violents";break;
            case "heavyt-stormswind":return "Orages violents / Vent";break;
            case "hvyrainfreezingrain":return "Forte pluie / Pluie verglaçante";break;
            case "icetorain":return "Givre puis Pluie";break;
            case "isot-stormswind":return "Orages isolés / Vent";break;
            case "isolatedt-storms":return "Orages isolés";break;
            case "lightdrizzle":return "Légère bruine";break;
            case "lightfreezingdrizzle":return "Légère bruine verglaçante";break;
            case "lightfreezingrain":return "Légère pluie verglaçante";break;
            case "lightrain":return "Légère pluie";break;
            case "lightrainearly":return "Légère pluie";break;
            case "lightrainfog":return "Légère pluie / Brouillard";break;
            case "lightrainfreezingrain":return "Légère pluie / Pluie verglaçante";break;
            case "lightrainlate":return "Légère pluie tardive";break;
            case "lightrainwind":return "Légère pluie / Vent";break;
            case "lightrainandfog":return "Légère pluie et Brouillard";break;
            case "lightrainandfreezingrain":return "Légère pluie et Pluie verglaçante";break;
            case "lightrainandwindy":return "Légère pluie et Vent";break;
            case "lightrainshower":return "Légères averses";break;
            case "lightrainshowerandwindy":return "Légères averses et Vent";break;
            case "lightrainwiththunder":return "Légère pluie avec tonnerre";break;
            case "lightsnow":return "Légères chutes de neige";break;
            case "lightsnowwind":return "Légère neige / Vent";break;
            case "lightsnowandfog":return "Légère neige et Brouillard";break;
            case "lightsnowfog":return "Légère neige et Brouillard";break;
            case "lightsnowearly":return "Légères chutes de neige";break;
            case "lightsnowgrains":return "Légers granules de neige";break;
            case "lightsnowgrainsandfog":return "Légers granules de neige et Brouillard";break;
            case "lightsnowlate":return "Légères chutes de neige";break;
            case "lightsnowshower":return "Légères chutes de neige";break;
            case "lightsnowshowerwind":return "Légères chutes de neige / Vent";break;
            case "mist":return "Brume";break;
            case "mostlyclear":return "Ciel plutôt dégagé";break;
            case "mostlyclearwind":return "Ciel plutôt dégagé / Vent";break;
            case "mostlycloudy":return "Plutôt nuageux";break;
            case "mostlycloudywind":return "Plutôt nuageux / Vent";break;
            case "mostlycloudyandwindy":return "Plutôt nuageux et Venteux";break;
            case "mostlysunny":return "Plutôt ensoleillé";break;
            case "mostlysunnywind":return "Plutôt ensoleillé / Vent";break;
            case "partlycloudy":return "Passages nuageux";break;
            case "partlycloudywind":return "Passages nuageux / Vent";break;
            case "partlycloudyandwindy":return "Passages nuageux et Vent";break;
            case "patchesoffog":return "Bancs de brouillard";break;
            case "pmdrizzle":return "Bruine dans l'après-midi";break;
            case "pmfog":return "Brouillard dans l'après-midi";break;
            case "pmlightrain":return "Légère pluie dans l'après-midi";break;
            case "pmlightrainice":return "Légère pluie dans l'après-midi / Verglas";break;
            case "pmlightrainwind":return "Légère pluie dans l'après-midi / Vent";break;
            case "pmlightsnow":return "Légères chutes de neige dans l'après-midi";break;
            case "pmlightsnowwind":return "Légères chutes de neige dans l'après-midi / Vent";break;
            case "pmrain":return "Pluie dans l'après-midi";break;
            case "pmrainsnow":return "Pluie / Neige dans l'après-midi";break;
            case "pmrainsnowwind":return "Pluie / Neige / Vent dans l'après-midi";break;
            case "pmrainsnowshowers":return "Pluie / Chutes de neige dans l'après-midi";break;
            case "pmshowers":return "Averses dans l'après-midi";break;
            case "pmshowerswind":return "Averses / Vent dans l'après-midi";break;
            case "pmsnow":return "Chutes de neige dans l'après-midi";break;
            case "pmsnowwind":return "Chutes de neige dans l'après-midi / Vent";break;
            case "pmsnowshowers":return "Chutes de neige dans l'après-midi";break;
            case "pmsnowshowerswind":return "Chutes de neige dans l'après-midi / Vent";break;
            case "pmt-showers":return "Averses orageuses dans l'après-midi";break;
            case "pmt-storms":return "Orages dans l'après-midi";break;
            case "pmwintrymix":return "Précipitations hivernales dans l'après-midi";break;
            case "rain":return "Pluie";break;
            case "rainfreezingrain":return "Pluie / Pluie verglaÃ§ante";break;
            case "rainsleet":return "Pluie / Granules de glace";break;
            case "rainsnow":return "Pluie / Neige";break;
            case "rainsnowlate":return "Pluie / Neige tardive";break;
            case "rainsnowwind":return "Pluie / Neige / Vent";break;
            case "rainsnowshowers":return "Pluie / Chutes de neige";break;
            case "rainsnowshowerswind":return "Pluie / Chutes de neige / Vent";break;
            case "rainsnowshowerslate":return "Pluie / Chutes de neige";break;
            case "rainthunder":return "Pluie / Tonnerre";break;
            case "rainthunderwind":return "Pluie / Tonnerre / Vent";break;
            case "rainwind":return "Pluie / Vent";break;
            case "rainandsleet":return "Pluie et Granules de glace";break;
            case "rainandsnow":return "Pluie et Neige";break;
            case "rainshower":return "Averses";break;
            case "rainshowerandwindy":return "Averses et Vent";break;
            case "raintosnow":return "Pluie devenant neige";break;
            case "raintosnowwind":return "Pluie devenant neige / Vent";break;
            case "scatteredflurries":return "Chutes de neige fondante éparses";break;
            case "scatteredflurrieswind":return "Chutes de neige fondante éparses / Vent";break;
            case "scatteredshowers":return "Averses éparses";break;
            case "scatteredshowerswind":return "Averses éparses / Vent";break;
            case "scatteredsnowshowers":return "Alternance de chutes de neige";break;
            case "scatteredsnowshowerswind":return "Chutes de neige éparses / Vent";break;
            case "scatteredstrongstorms":return "Orages violents épars";break;
            case "scatteredt-storms":return "Orages épars";break;
            case "scatteredt-stormswind":return "Orages épars / Vent";break;
            case "shallowfog":return "Brouillard";break;
            case "showers":return "Averses";break;
            case "showerswind":return "Averses / Vent";break;
            case "showerswindlate":return "Averses / Vent";break;
            case "showersearly":return "Averses";break;
            case "showersinthevicinity":return "Averses dans le voisinage";break;
            case "showerslate":return "Averses";break;
            case "sleet":return "Granules de glace ";break;
            case "smoke":return "Fumée";break;
            case "snow":return "Neige";break;
            case "snowwind":return "Neige / Vent";break;
            case "snowandfog":return "Neige et Brouillard";break;
            case "snowandicetorain":return "Neige et Glace puis Pluie";break;
            case "snowgrains":return "Granules de neige";break;
            case "snowshower":return "Chutes de neige";break;
            case "snowshowerwind":return "Chutes de neige / Vent";break;
            case "snowshowerwindearly":return "Chutes de neige / Vent";break;
            case "snowshowersearly":return "Chutes de neige";break;
            case "snowshowerslate":return "Chutes de neige tardive";break;
            case "snowtoice":return "Neige puis Verglas";break;
            case "snowtoicewind":return "Neige se transformant en glace / Vent";break;
            case "snowtorain":return "Neige puis Pluie";break;
            case "snowtorainwind":return "Neige puis Pluie / Vent";break;
            case "snowtowintrymix":return "Neige puis Précipitations hivernales";break;
            case "sprinkles":return "Averses";break;
            case "strongstorms":return "Orages violents";break;
            case "strongstormswind":return "Orages violents / Vent";break;
            case "sunny":return "Ensoleillé";break;
            case "sunnywind":return "Ensoleillé / Vent";break;
            case "sunnyandwindy":return "Ensoleillé et Venteux";break;
            case "t-showers":return "Averses orageuses";break;
            case "t-showerswind":return "Averses orageuses / Vent";break;
            case "t-storm":return "Orage";break;
            case "t-storms":return "Orages";break;
            case "t-stormswind":return "Orages / Vent";break;
            case "t-stormsearly":return "Orages";break;
            case "t-stormslate":return "Orages";break;
            case "thunder":return "Tonnerre";break;
            case "thunderandwintrymix":return "Tonnerre et Précipitations hivernales";break;
            case "thunderinthevicinity":return "Tonnerre dans le voisinage";break;
            case "unknownprecip":return "Précipitations";break;
            case "widespreaddust":return "Brume sèche";break;
            case "wintrymix":return "Précipitations hivernales";break;
            case "wintrymixwind":return "Précipitations hivernales / Vent";break;
            case "wintrymixtosnow":return "Précipitations hivernales puis Neige";break;
            default : return $temps;break;
        }
    }

    function getWeather($city_code, $days, $duMoment = true)
    {
       
        $weather = new DomDocument;
        $weather->load('http://wxdata.weather.com/wxdata/weather/local/' . $city_code . '?cc=*&unit=m&dayf=' . $days);

        if ($duMoment == true) {
            /*
            * meteo actuel
            */
            $meteoActuel = $weather->getElementsByTagName('cc'); 
            
            foreach ($meteoActuel as $meteo) {

                $Day['actuel']["temperature"]= $meteo->getElementsByTagName("tmp")->item(0)->nodeValue; 
                $Day['actuel']["temperatureRessentie"]= $meteo->getElementsByTagName("flik")->item(0)->nodeValue; 
                $Day['actuel']["humidite"]= $meteo->getElementsByTagName("hmid")->item(0)->nodeValue; 
                $Day['actuel']["visibilite"]= $meteo->getElementsByTagName("vis")->item(0)->nodeValue; 
                $Day['actuel']["pointDeRose"]= $meteo->getElementsByTagName("dewp")->item(0)->nodeValue;

                $pression = $meteo->getElementsByTagName('bar'); 
                foreach ($pression as $press) {
                    $Day['actuel']['press']["r"] = $press->getElementsByTagName("r")->item(0)->nodeValue;
                    $Day['actuel']['press']["d"] = $this->temps_FR($press->getElementsByTagName("d")->item(0)->nodeValue);
                }

                $pression = $meteo->getElementsByTagName('wind'); 
                foreach ($pression as $press) {
                    $Day['actuel']['wind']["s"] = $press->getElementsByTagName("s")->item(0)->nodeValue;
                    $Day['actuel']['wind']["gust"] = $press->getElementsByTagName("gust")->item(0)->nodeValue;
                    $Day['actuel']['wind']["d"] = $press->getElementsByTagName("d")->item(0)->nodeValue;
                    $Day['actuel']['wind']["t"] = $press->getElementsByTagName("t")->item(0)->nodeValue;
                }

                $pression = $meteo->getElementsByTagName('uv'); 
                foreach ($pression as $press) {
                    $Day['actuel']['uv']["i"] = $press->getElementsByTagName("i")->item(0)->nodeValue;
                    $Day['actuel']['uv']["t"] = $this->temps_FR($press->getElementsByTagName("t")->item(0)->nodeValue);
                }

                $pression = $meteo->getElementsByTagName('moon'); 
                foreach ($pression as $press) {
                    $Day['actuel']['moon']["icon"] = $press->getElementsByTagName("icon")->item(0)->nodeValue;
                    $Day['actuel']['moon']["t"] = $this->temps_FR($press->getElementsByTagName("t")->item(0)->nodeValue);
                }


            }
        }
        /*
        * meteo du jour et jour suivants
        */
        $elements = $weather->getElementsByTagName('day'); 
 
          foreach ($elements as $enfant) {

            $idJour = "jour".$enfant->getAttribute('d');
  
            if ($enfant->nodeType == XML_ELEMENT_NODE) {
            
                $Day[$idJour]['jour'] = $this->date_fr($enfant->getAttribute('t')." ".$enfant->getAttribute('dt'));
             
            }

            /*
            *   information epi
            */
            $Day[$idJour]['TempMax']= $enfant->getElementsByTagName("hi")->item(0)->nodeValue; 
            $Day[$idJour]['TempMin']= $enfant->getElementsByTagName("low")->item(0)->nodeValue; 
            $Day[$idJour]['soleilLeve']= $this->to24H($enfant->getElementsByTagName("sunr")->item(0)->nodeValue); 
            $Day[$idJour]['soleilCouche']= $this->to24H($enfant->getElementsByTagName("suns")->item(0)->nodeValue); 


            /*
            *   partie de la journée Day/Night
            */
            $parties = $enfant->getElementsByTagName('part');

            foreach ($parties as $partie) {
                $partieJournee = $partie->getAttribute('p');

                $Day[$idJour]["partie"][$partieJournee]['icon'] = $partie->getElementsByTagName("icon")->item(0)->nodeValue;
                $Day[$idJour]["partie"][$partieJournee]['t'] = $this->temps_FR($partie->getElementsByTagName("t")->item(0)->nodeValue);


                /*
                *   vents
                */
                $vents = $partie->getElementsByTagName("wind");
                foreach ($vents as $vent) {
                    $Day[$idJour]["partie"][$partieJournee]['ventVitesse'] = $vent->getElementsByTagName("s")->item(0)->nodeValue;
                    $Day[$idJour]["partie"][$partieJournee]['VentMax'] = $vent->getElementsByTagName("gust")->item(0)->nodeValue;
                    $Day[$idJour]["partie"][$partieJournee]['ventDirectionEnDegree'] = $vent->getElementsByTagName("d")->item(0)->nodeValue;
                    $Day[$idJour]["partie"][$partieJournee]['ventDirection'] = $this->temps_FR($vent->getElementsByTagName("t")->item(0)->nodeValue); 
                }

                /*
                *   pluie
                */
                $Day[$idJour]["partie"][$partieJournee]['btd'] = $partie->getElementsByTagName("bt")->item(0)->nodeValue; //aucune idée sur cette information
                $Day[$idJour]["partie"][$partieJournee]['PourcentageDePrecipitation'] = $partie->getElementsByTagName("ppcp")->item(0)->nodeValue;
                $Day[$idJour]["partie"][$partieJournee]['humidite'] = $partie->getElementsByTagName("hmid")->item(0)->nodeValue;

            }
            

         }

         return $Day;
    
    }
    
}

?>