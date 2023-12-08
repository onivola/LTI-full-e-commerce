<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modele_Menudrop extends CI_Model
{
	protected $ctable = 'categorie';
	protected $cstable = 's_categorie';
	protected $csstable = 'ss_categorie';

	public function SelectCat() 
	{
		return $this->db->select('*')
		->from($this->ctable)
		->get()
		->result();
	}
	
	public function SelectScIdWhere($ID_CATEGORIE) 
	{
        $where = array('ID_CATEGORIE'=>$ID_CATEGORIE);
		return $this->db->select('*')
		->from($this->cstable)
		->Where($where)
		->get()
		->result();
    }
    public function SelectSscIdWhere($ID_CATEGORIE,$ID_S_CATEGORIE) 
	{
        $where = array('ID_CATEGORIE'=>$ID_CATEGORIE,'ID_S_CATEGORIE'=>$ID_S_CATEGORIE);
		return $this->db->select('*')
		->from($this->csstable)
		->Where($where)
		->get()
		->result();
    }
}
?>