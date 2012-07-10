<?php 
#Algoritmo basado en c# 
#Hecho por: Quito Marzo 2009, cyberquito@yahoo.com. 
 function rfcset($a,$b) { #una manera de asignar defaults.  
        if (!$a) return $b; else return $a; 
    } 
     
 class RFC { 
    var $nombre,$apellidoPaterno, $apellidoMaterno, $fecha,$rfc; 
     
    function RFC($nombre,$apellidoPaterno, $apellidoMaterno, $fecha) { #formato de fecha: YYYY-MM-DD 
         $this->nombre = strtoupper(trim($nombre)); 
        //Quitamos los artículos de los apellidos 
         
        $this->apellidoPaterno = $this->QuitarArticulos(strtoupper(trim($apellidoPaterno))); 
        $this->apellidoMaterno = $this->QuitarArticulos(strtoupper(trim($apellidoMaterno))); 
         
        //Agregamos el primer caracter del apellido paterno 
         $this->rfc=substr($this->apellidoPaterno,0,1); 
          
         //Buscamos y agregamos al rfc la primera vocal del primer apellido 
        for ($i=0;$i<strlen($this->apellidoPaterno);$i++) { 
            $c=$this->apellidoPaterno[$i]; 
            if ($this->EsVocal($c)) { 
                $this->rfc.=$c; 
                break; 
            } 
        } 
        //Agregamos el primer caracter del apellido materno 
        $this->rfc.=substr($this->apellidoMaterno,0,1); 
         

        //Agregamos el primer caracter del primer nombre 
        $this->rfc.=substr($this->nombre,0,1); 

        //Agregamos la fecha yyyy-mm-dd (por ejemplo: 1968-08-25 = 25 de agosto de 1968 ); por si las dudas, ponemos un cero a la izquierda de los meses y dias < 10 
        $efecha=explode("-",$fecha);$efecha[0]=substr($efecha[0],2,2);$efecha[1]=str_pad($efecha[1],2,'0',STR_PAD_LEFT);$efecha[2]=str_pad($efecha[2],2,'0',STR_PAD_LEFT); 
        $fecha=implode("",$efecha); 
        $this->rfc.=$fecha; 
         
        //Le agregamos la homoclave al rfc  
        $homoclave=$this->CalcularHomoclave($this->apellidoPaterno . " " . $this->apellidoMaterno . " " . $this->nombre, $this->fecha); 
        $this->rfc.=$homoclave; 
          
     }# 
      
     
    function EsVocal($letra) { 
        $letra=strtoupper($letra); 
        $vocales=array("A","E","I","O","U","Á","É","Í","Ó","Ú"); 
        if (in_array($letra,$vocales))  
            return true; 
        else  
            return false; 
    }# 

    function QuitarArticulos($palabra) { 
        $articulos=array("DEL ","LAS ","DE ","LA ","Y ","A "); 
        $palabra=str_replace($articulos,"",$palabra); 
        return $palabra; 
    }# 
    function CalcularHomoclave($nombreCompleto, $fecha) { 
         
        $nombreEnNumero=""; //Guardara el nombre en su correspondiente numérico 
        $valorSuma = 0; //La suma de la secuencia de números de nombreEnNumero 

        #region Tablas para calcular la homoclave. Estas tablas realmente no se porque son como son. solo las copie de lo que encontré en internet 

        #region TablaRFC 1 
        $tablaRFC1 = array(); 
        $tablaRFC1["&"]=10; 
        $tablaRFC1["Ñ"]=10; 
        $tablaRFC1["A"]=11; 
        $tablaRFC1["B"]=12; 
        $tablaRFC1["C"]=13; 
        $tablaRFC1["D"]=14; 
        $tablaRFC1["E"]=15; 
        $tablaRFC1["F"]=16; 
        $tablaRFC1["G"]=17; 
        $tablaRFC1["H"]=18; 
        $tablaRFC1["I"]=19; 
        $tablaRFC1["J"]=21; 
        $tablaRFC1["K"]=22; 
        $tablaRFC1["L"]=23; 
        $tablaRFC1["M"]=24; 
        $tablaRFC1["N"]=25; 
        $tablaRFC1["O"]=26; 
        $tablaRFC1["P"]=27; 
        $tablaRFC1["Q"]=28; 
        $tablaRFC1["R"]=29; 
        $tablaRFC1["S"]=32; 
        $tablaRFC1["T"]=33; 
        $tablaRFC1["U"]=34; 
        $tablaRFC1["V"]=35; 
        $tablaRFC1["W"]=36; 
        $tablaRFC1["X"]=37; 
        $tablaRFC1["Y"]=38; 
        $tablaRFC1["Z"]=39; 
        $tablaRFC1["0"]=0; 
        $tablaRFC1["1"]=1; 
        $tablaRFC1["2"]=2; 
        $tablaRFC1["3"]=3; 
        $tablaRFC1["4"]=4; 
        $tablaRFC1["5"]=5; 
        $tablaRFC1["6"]=6; 
        $tablaRFC1["7"]=7; 
        $tablaRFC1["8"]=8; 
        $tablaRFC1["9"]=9; 
        $tablaRFC1[" "]= ""; 
        #endregion 

        #region TablaRFC 2 
        $tablaRFC2 = array(); 
        $tablaRFC2[0]= "1"; 
        $tablaRFC2[1]= "2"; 
        $tablaRFC2[2]= "3"; 
        $tablaRFC2[3]= "4"; 
        $tablaRFC2[4]= "5"; 
        $tablaRFC2[5]= "6"; 
        $tablaRFC2[6]= "7"; 
        $tablaRFC2[7]= "8"; 
        $tablaRFC2[8]= "9"; 
        $tablaRFC2[9]= "A"; 
        $tablaRFC2[10]= "B"; 
        $tablaRFC2[11]= "C"; 
        $tablaRFC2[12]= "D"; 
        $tablaRFC2[13]= "E"; 
        $tablaRFC2[14]= "F"; 
        $tablaRFC2[15]= "G"; 
        $tablaRFC2[16]= "H"; 
        $tablaRFC2[17]= "I"; 
        $tablaRFC2[18]= "J"; 
        $tablaRFC2[19]= "K"; 
        $tablaRFC2[20]= "L"; 
        $tablaRFC2[21]= "M"; 
        $tablaRFC2[22]= "N"; 
        $tablaRFC2[23]= "P"; 
        $tablaRFC2[24]= "Q"; 
        $tablaRFC2[25]= "R"; 
        $tablaRFC2[26]= "S"; 
        $tablaRFC2[27]= "T"; 
        $tablaRFC2[28]= "U"; 
        $tablaRFC2[29]= "V"; 
        $tablaRFC2[30]= "W"; 
        $tablaRFC2[31]= "X"; 
        $tablaRFC2[32]= "Y"; 
        #endregion 

        #region TablaRFC 3 
        $tablaRFC3 = array(); 
        $tablaRFC3["A"]= 10; 
        $tablaRFC3["B"]= 11; 
        $tablaRFC3["C"]=12; 
        $tablaRFC3["D"]= 13; 
        $tablaRFC3["E"]= 14; 
        $tablaRFC3["F"]= 15; 
        $tablaRFC3["G"]= 16; 
        $tablaRFC3["H"]= 17; 
        $tablaRFC3["I"]= 18; 
        $tablaRFC3["J"]= 19; 
        $tablaRFC3["K"]= 20; 
        $tablaRFC3["L"]= 21; 
        $tablaRFC3["M"]= 22; 
        $tablaRFC3["N"]= 23; 
        $tablaRFC3["O"]= 25; 
        $tablaRFC3["P"]= 26; 
        $tablaRFC3["Q"]= 27; 
        $tablaRFC3["R"]= 28; 
        $tablaRFC3["S"]= 29; 
        $tablaRFC3["T"]= 30; 
        $tablaRFC3["U"]= 31; 
        $tablaRFC3["V"]= 32; 
        $tablaRFC3["W"]= 33; 
        $tablaRFC3["X"]= 34; 
        $tablaRFC3["Y"]= 35; 
        $tablaRFC3["Z"]= 36; 
        $tablaRFC3["0"]= 0; 
        $tablaRFC3["1"]= 1; 
        $tablaRFC3["2"]= 2; 
        $tablaRFC3["3"]= 3; 
        $tablaRFC3["4"]= 4; 
        $tablaRFC3["5"]= 5; 
        $tablaRFC3["6"]= 6; 
        $tablaRFC3["7"]= 7; 
        $tablaRFC3["8"]= 8; 
        $tablaRFC3["9"]= 9; 
        $tablaRFC3[""]= 24; 
        $tablaRFC3[" "]= 37; 
        #endregion 

        //agregamos un cero al inicio de la representación númerica del nombre 
        $nombreEnNumero="0";  

        //Recorremos el nombre y vamos convirtiendo las letras en su valor numérico 
        for ($i=0;$i<strlen($nombreCompleto);$i++) { 
            $c=$nombreCompleto[$i]; 
        
            $nombreEnNumero.=rfcset($tablaRFC1[$c],"00"); 
        } 
             
        //Calculamos la suma de la secuencia de números calculados anteriormente.  
        //la formula es:( (el caracter actual multiplicado por diez) mas el valor del caracter siguiente ) 
        //(y lo anterior multiplicado por el valor del caracter siguiente) 
        /* codigo en c# 
            valorSuma += ((Convert.ToInt32(nombreEnNumero[i].ToString()) * 10) + Convert.ToInt32(nombreEnNumero[i + 1].ToString())) * Convert.ToInt32(nombreEnNumero[i + 1].ToString()); 
        */ 
        for ($i = 0; $i < strlen($nombreEnNumero) - 1; $i++) { $i2=$i+1; 
            $valorSuma+=(($nombreEnNumero[$i]*10) + $nombreEnNumero[$i2])*$nombreEnNumero[$i2]; 
             
        } 
         
        //Lo siguiente no se porque se calcula así, es parte del algoritmo. 
        //Los magic numbers que aparecen por ahí deben tener algún origen matemático 
        //relacionado con el algoritmo al igual que el proceso mismo de calcular el  
        //digito verificador. 
        //Por esto no puedo añadir comentarios a lo que sigue, lo hice por acto de fe. 

        $div = 0; $mod = 0; 
        $div = $valorSuma % 1000; 
        $mod = $div % 34; 
        $div = ($div - $mod) / 34; 
         
        $hc = "";  //los dos primeros caracteres de la homoclave 
        $hc.=rfcset($tablaRFC2[$div],"Z"); 
        $hc.=rfcset($tablaRFC2[$mod],"Z"); 
         
        /* codigo en c# 
            while ($indice <= 1) { 
                if (tablaRFC2.ContainsKey((indice == 0) ? div : mod)) 
                    hc += tablaRFC2[(indice == 0) ? div : mod]; 
                else 
                    hc += "Z"; 
                indice++; 
            } 
        */ 

        //Agregamos al RFC los dos primeros caracteres de la homoclave 
        $rfc=$this->rfc; 
        $rfc.=$hc; 

        //Aqui empieza el calculo del digito verificador basado en lo que tenemos del RFC 
        //En esta parte tampoco conozco el origen matemático del algoritmo como para dar  
        //una explicación del proceso, así que ¡tengamos fe hermanos!. 
        $rfcAnumeroSuma = 0; $sumaParcial = 0; 
        for ($i = 0; $i < strlen($rfc); $i++) { 
            if ($tablaRFC3[$rfc[$i]]) { 
                $rfcAnumeroSuma=$tablaRFC3[$rfc[$i]]; 
                $sumaParcial += ($rfcAnumeroSuma * (14 - ($i + 1))); 
            } 
        } 

        $moduloVerificador = $sumaParcial % 11; 
        if ($moduloVerificador == 0) 
            $hc.= "0"; 
        else { 
            $sumaParcial = 11 - $moduloVerificador; 
            if ($sumaParcial == 10) 
                $hc.= "A"; 
            else 
                $hc.= $sumaParcial; 
        } 

        return $hc; 
    }# 

     
     
}## 


#ejemplo 

#$nombre="hector"; 
#$apellidoPaterno="ceron"; 
#$apellidoMaterno="figueroa"; 
#$fecha="1989-04-04"; 
#$rfc= new RFC ($nombre,$apellidoPaterno, $apellidoMaterno, $fecha); 
#echo $rfc->rfc; 

?>
