<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modele extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('encryption');

  
     
     //# Générer la clé privée RSA (4096 bits)
     //openssl genpkey -algorithm RSA -out private.pem -pkeyopt rsa_keygen_bits:4096

      # Extraire la clé publique de la clé privée
      //openssl rsa -pubout -in private.pem -out public.pem

    // Charger les clés privées et publiques RSA
     $this->privateKey = openssl_pkey_get_private(file_get_contents(APPPATH . 'keys/private.pem'));
     $this->publicKey = openssl_pkey_get_public(file_get_contents(APPPATH . 'keys/public.pem'));
 }

 /**
     * Enregistrer un vote et le signer numériquement.
     * @param int $id_utilisateur ID de l'électeur.
     * @param int $id_candidat ID du candidat choisi.
     * @return bool
     */
    public function enregistrer_vote($id_utilisateur, $id_candidat) {
      $vote_data = $id_utilisateur . '|' . $id_candidat;

      // Signer le vote avec la clé privée RSA
      $signature = null;
      openssl_sign($vote_data, $signature, $this->privateKey, OPENSSL_ALGO_SHA256);
      $signature_base64 = base64_encode($signature);  // Encoder la signature en Base64

      // Enregistrer le vote chiffré et la signature dans la base de données
      $data = array(
          'ID_UTILISATEUR' => $id_utilisateur,
          'ID_CANDIDAT' => $id_candidat,
          'ENCRYPTED_VOTE' => base64_encode($vote_data),  // Si vous chiffrez les votes avec AES
          'SIGNATURE' => $signature_base64
      );

      return $this->db->insert('votes', $data);
  }

  /**
   * Vérifier l'intégrité et l'authenticité du vote à l'aide de la clé publique RSA.
   * @param string $vote_data Données du vote.
   * @param string $signature Signature numérique associée.
   * @return bool True si la signature est valide, sinon false.
  
     * Vérifie si la signature d'un vote est valide.
     * @param int $id_utilisateur ID de l'utilisateur.
     * @param int $id_candidat ID du candidat.
     * @param string $signature_base64 La signature base64 du vote.
     * @return bool Retourne true si la signature est valide, sinon false.
     */
    public function verifier_signature($id_utilisateur, $id_candidat, $signature_base64) {
      // Concaténer les données du vote dans le même format que lors de l'enregistrement
      $vote_data = $id_utilisateur . '|' . $id_candidat;
      $signature = base64_decode($signature_base64);  // Décoder la signature encodée en base64
      print_r($signature);
      print_r($vote_data);

      
      // Vérifier la signature avec la clé publique RSA
      $is_valid = openssl_verify($vote_data, $signature, $this->publicKey, OPENSSL_ALGO_SHA256);
      // print_r($is_valid);
      exit();
      // Debugging : afficher le statut de la vérification de la signature
      if ($is_valid === 1) {
          return true;  // Signature valide
      } elseif ($is_valid === 0) {
          echo "Signature invalide pour l'utilisateur ID: $id_utilisateur, candidat ID: $id_candidat.";
          return false;  // Signature invalide
      } else {
          echo "Erreur lors de la vérification de la signature : " . openssl_error_string();
          return false;  // Erreur lors de la vérification
      }
  }
  
    /**
     * Compte les votes valides pour chaque candidat.
     * @return array Retourne un tableau avec les candidats et le nombre de votes valides.
     */
      public function compter_votes_valides() {
        // Requête pour récupérer les votes avec les candidats
        $this->db->select('c.NOM, c.PRENOM,v.ID_CANDIDAT,v.ID_UTILISATEUR,v.SIGNATURE, COUNT(v.ID_VOTE) as nombre_votes');
        $this->db->from('votes v');
        $this->db->join('participants c', 'v.ID_CANDIDAT = c.ID_PARTICIPANT ');
        $this->db->group_by('v.ID_CANDIDAT');

        $result = $this->db->get()->result_array();
  
        $votes_valides = [];
        foreach ($result as $vote) {
            // Vérifier chaque vote pour valider sa signature
            if ($this->verifier_signature($vote['ID_UTILISATEUR'], $vote['ID_CANDIDAT'], $vote['SIGNATURE'])) {
                // Ajouter le candidat et le nombre de votes valides
                $votes_valides[] = [
                    'NOM_CANDIDAT' => $vote['NOM'],
                    'PRENOM_CANDIDAT' => $vote['PRENOM'],
                    'nombre_votes' => $vote['nombre_votes']
                ];
            }
        }

        return $votes_valides;
    }

  public function create($table,$data){
    $sql=$this->db->insert($table,$data);
    return $sql ;
  }
  function readRequeteOne($requete){
    $query=$this->db->query($requete);
    if ($query) {
      return $query->row_array();
    }
  }
  //pacifique
  function vider($requete)
  {
         $query=$this->db->query($requete);
          return $query;
  }
  public function Add_data($table,$data){
    $sql=$this->db->insert($table,$data);
    return $sql ;
  }

  public function getList($table,$condition = array()){
    if(!empty($condition)){
      $this->db->where($condition);
    }
		$sql=$this->db->get($table) ;

    return $sql->result_array() ;
	}

  public function getOne($table,$where){
    $this->db->where($where) ;
    $sql=$this->db->get($table) ;
    return $sql->row_array() ;
  }

  public function deleteData($table,$where){
    $this->db->where($where);
    $sql=$this->db->delete($table) ;
    return $sql;
  }

  public function updateData($table,$data,$where){
    $this->db->where($where) ;
    $sql=$this->db->update($table,$data) ;
    return $sql;
  }


  function getListOrder($table,$criteres)
  {
    $this->db->order_by($criteres);
    $query= $this->db->get($table);
    if($query)
    {
      return $query->result_array();
    }
  }
function insert_batch($table,$data){

    $query=$this->db->insert_batch($table, $data);
    return ($query) ? true : false;
    //return ($query)? true:false;

}


  public function sql_one_query($query){
    $sql=$this->db->query($query);
    return $sql->row_array();
  }
  public function sql_all_query($query){
    $sql=$this->db->query($query);
    return $sql->result_array();
  }

  function insert_last_id($table, $data) {

    $query = $this->db->insert($table, $data);

    if ($query) {
      return $this->db->insert_id();
    }

  }

    public function maker($requete)//make query
    {
      return $this->db->query($requete);
    }

    public function datatable($requete)//make_datatables : requete avec Condition,LIMIT start,length
    { 
        $query =$this->maker($requete);//call function make query
        return $query->result();
    }  
    public function all_data($requete)//count_all_data : requete sans Condition sans LIMIT start,length
    {
       $query =$this->maker($requete); //call function make query
       return $query->num_rows();
     }
     public function filtrer($requete)//get_filtered_data : requete avec Condition sans LIMIT start,length
     {
         $query =$this->maker($requete);//call function make query
         return $query->num_rows();

       }

       function getRequete($requete){
         $query=$this->db->query($requete);
         if ($query) {
          return $query->result_array();
        }
      }


        function getRequete1($requete){
         $query=$this->db->query($requete);
        //  if ($query) {
        //   return $query->result_array();
        // }
      }

      function getRequete_object($requete){
       $query=$this->db->query($requete);
       if ($query) {
        return $query->result();
      }
    }

     // public function update($table,$data,$where){
     //   $this->db->where($where) ;
     //   $sql=$this->db->update($table,$data) ;
     //   return $sql;
     // }

    function update($table, $criteres, $data) {
      $this->db->where($criteres);
      $query = $this->db->update($table, $data);
      return ($query) ? true : false;
    }

    public function delete($table,$where){
     $this->db->where($where);
     $sql=$this->db->delete($table) ;
     return $sql;
   }

   function getRequeteOne($requete){
     $query=$this->db->query($requete);
     if ($query) {
      return $query->row_array();
    }
  }

  public function get_permission($url)
  {
       //  echo $this->session->userdata('INFINITY_POSTE_ID');
   $this->db->select('af.*');
   $this->db->from('admin_fonctionnalites af');
   $this->db->join('admin_profil_fonctionnalites afp','afp.FONCTIONNALITE_ID = af.FONCTIONNALITE_ID');
   $this->db->where('af.FONCTIONNALITE_URL',$url);
   $this->db->where('afp.PROFIL_ID',$this->session->userdata('iccm_PROFIL_ID'));

   $query = $this->db->get();
       //  echo $this->db->last_query();
   if($query){
     return $query->row_array();
   }
 }





    ///edmond gica11
//  public function make_datatables_intra_now($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//  {
//   $this->make_query_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by);
//   if($_POST['length'] != -1){
//    $this->db->limit($_POST["length"],$_POST["start"]);
//  }
//  $query = $this->db->get();
//  return $query->result();
// }

public function make_query_intra_now($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_intervenat', 'stock_intervenat.STOCK_INTERVENANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('intervenants_structure', 'intervenants_structure.INTERVENANT_STRUCTURE_ID=stock_intervenat.INTERVENANT_STRUCTURE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_now($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_intervenat', 'stock_intervenat.STOCK_INTERVENANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
 $this->db->join('intervenants_structure', 'intervenants_structure.INTERVENANT_STRUCTURE_ID=stock_intervenat.INTERVENANT_STRUCTURE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_now($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}
//pacy
public function mois($moi=0){
            $moislettre='';
            if($moi==1)
                $moislettre='Janvier';
            if($moi==2)
                $moislettre='Février';
            if($moi==3)
                $moislettre='Mars';
            if($moi==4)
                $moislettre='Avril';
            if($moi==5)
                $moislettre='Mai';
            if($moi==6)
                $moislettre='Juin';
            if($moi==7)
                $moislettre='Juillet';
            if($moi==8)
                $moislettre='Août';
            if($moi==9)
                $moislettre='Septembre';
            if($moi==10)
                $moislettre='Octobre';
            if($moi==11)
                $moislettre='Novembre';
            if($moi==12)
                $moislettre='Décembre';

            return $moislettre;
        }




        ///edmond gica11
//  public function make_datatables_intra_dash($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//  {
//   $this->make_query_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by);
//   if($_POST['length'] != -1){
//    $this->db->limit($_POST["length"],$_POST["start"]);
//  }
//  $query = $this->db->get();
//  return $query->result();
// }

public function make_query_intra_dash($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_distribution', 'stock_distribution.DISTRIBUTION_ID=stock_distribution_intrant_detail.DISTRIBUTION_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_distribution.DEMANDE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_dash($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_distribution', 'stock_distribution.DISTRIBUTION_ID=stock_distribution_intrant_detail.DISTRIBUTION_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_distribution.DEMANDE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_dash($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}

///edmond gica11
//  public function make_datatables_intra_anfin($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//  {
//   $this->make_query_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by);
//   if($_POST['length'] != -1){
//    $this->db->limit($_POST["length"],$_POST["start"]);
//  }
//  $query = $this->db->get();
//  return $query->result();
// }

public function make_query_intra_anfin($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
{
  $this->db->select($select_column);
  $this->db->from($table);
  $this->db->join('stock_demande_detail', 'stock_demande_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_demande_detail.DEMANDE_ID','left');

  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intra_anfin($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('stock_demande_detail', 'stock_demande_detail.INTRANT_ID='.$table.'.INTRANT_MEDICAUX_ID','left');
  $this->db->join('stock_demande', 'stock_demande.DEMANDE_ID=stock_demande_detail.DEMANDE_ID','left');


 return $this->db->count_all_results();
}
public function get_filtered_data_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intra_anfin($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}



///emery le 28/05/2021



///edmond gica11
//  public function make_datatables_intrants_distribution_stock($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//  {
//   $this->make_query_intrants_distribution_stock($table,$select_column,$critere_txt,$critere_array,$order_by);
//   if($_POST['length'] != -1){
//    $this->db->limit($_POST["length"],$_POST["start"]);
//  }
//  $query = $this->db->get();
//  return $query->result();
// }

public function make_query_intrants_distribution_stock($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
      {
  $this->db->select($select_column);
  $this->db->from($table);

   $this->db->join('intrant_medicaux', 'intrant_medicaux.INTRANT_MEDICAUX_ID='.$table.'.INTRANT_ID');

  $this->db->join('stock_distribution', 'stock_distribution.DEMANDE_ID='.$table.'.DEMANDE_ID','left');

  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.DISTRIBUTION_ID=stock_distribution.DISTRIBUTION_ID');


  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
    $this->db->where($critere_array);

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intrants_distribution_stock($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);
 $this->db->join('intrant_medicaux', 'intrant_medicaux.INTRANT_MEDICAUX_ID='.$table.'.INTRANT_ID');

  $this->db->join('stock_distribution', 'stock_distribution.DEMANDE_ID='.$table.'.DEMANDE_ID','left');

  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.DISTRIBUTION_ID=stock_distribution.DISTRIBUTION_ID');


 return $this->db->count_all_results();
}
public function get_filtered_data_intrants_distribution_stock($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intrants_distribution_stock($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}





///emery le 28/05/2021


//  public function make_datatables_intrants_distribution_stock_new($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
//  {
//   $this->make_query_intrants_distribution_stock_new($table,$select_column,$critere_txt,$critere_array,$order_by);
//   if($_POST['length'] != -1){
//    $this->db->limit($_POST["length"],$_POST["start"]);
//  }
//  $query = $this->db->get();
//  return $query->result();
// }

public function make_query_intrants_distribution_stock_new($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
      {
  $this->db->select($select_column);
  $this->db->from($table);

 $this->db->join('stock_distribution', 'stock_distribution.DEMANDE_ID='.$table.'.DEMANDE_ID','left');

  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.DISTRIBUTION_ID=stock_distribution.DISTRIBUTION_ID');


  if($critere_txt != NULL){
    $this->db->where($critere_txt);
  }
  if(!empty($critere_array))
  {
    $this->db->where($critere_array);
   }

  $this->db->group_by('stock_demande_detail.DEMANDE_ID');

  if(!empty($order_by)){
    $key = key($order_by);
    $this->db->order_by($key,$order_by[$key]);
  }

}
public function count_all_data_intrants_distribution_stock_new($table,$critere = array(),$critere_txt=NULL)
{
 $this->db->select('*');

 $this->db->where($critere);
 if($critere_txt != NULL)
   $this->db->where($critere);
 $this->db->from($table);

  $this->db->join('stock_distribution', 'stock_distribution.DEMANDE_ID='.$table.'.DEMANDE_ID','left');

  $this->db->join('stock_distribution_intrant_detail', 'stock_distribution_intrant_detail.DISTRIBUTION_ID=stock_distribution.DISTRIBUTION_ID');


 return $this->db->count_all_results();
}
public function get_filtered_data_intrants_distribution_stock_new($table,$select_column,$critere_txt,$critere_array,$order_by)
{
  $this->make_query_intrants_distribution_stock_new($table,$select_column,$critere_txt,$critere_array,$order_by);
  $query = $this->db->get();
  return $query->num_rows();

}



}
