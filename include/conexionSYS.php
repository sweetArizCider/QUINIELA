<?php

/*Conexión LDAP*/

function conecta_ldap($servidor,$puerto)
        { 
            try{

                    $ds=ldap_connect($servidor,$puerto);              

            }catch(Exception $e){
                    $ds = "No fue posible conectarse al LDAP" . $e->getMessage();
            }

            return $ds;
    }

    function busca_info_ldap($conexion,$rama,$filtro,$campos,$ordenar,$orden)
      {

          $result   = ldap_search($conexion, $rama, $filtro, $campos);

          if($ordenar == 1){ $ordenado = ldap_sort($conexion,$result,'uid'); }

          $datos    = ldap_get_entries($conexion,$result);
          return $datos;

      }

    function bind_ldap($ds)
        {  
          $con=ldap_bind($ds,"cn=SP_PROXSEG,o=PENOLES","P3n0l3sMMXII");
          return $con;
        }

/*Fin Conexión LDAP*/

/*Conexión LEGADOS

function conecta_legados()
{
  $dbc= '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = lgbdpr01.splata.penoles.mx)(PORT = 50700)))(CONNECT_DATA =(SERVICE_NAME = LEGPROD)))';
  $conLeg = @OCILogon("OVSI","OVSIAC",$dbc) or die("No me puedo conectar a Oracle legados"); #"system","systemsdeskpru","PruebasSD" 
  if (!$conLeg) { $e = OCIError(); Print($e); }
  return $conLeg;
}

/*Fin Conexión LEGADOS*/
?>