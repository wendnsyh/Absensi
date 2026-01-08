<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Denda_model extends CI_Model
{
    private $table = 'denda';

    public function get_all()
    {
        return $this->db->order_by('menit_min', 'ASC')->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id_denda', $id)->update($this->table, $data);
    }

    public function get_denda_by_menit($menit)
    {
        return $this->db
            ->where('menit_min <=', $menit)
            ->where('menit_max >=', $menit)
            ->get($this->table)
            ->row();
    }

    public function get_by_id($id_denda)
    {
        return $this->db
            ->where('id_denda', $id_denda)
            ->get($this->table)
            ->row();
    }

    public function delete($id_denda)
    {
        return $this->db
            ->where('id_denda', $id_denda)
            ->delete('denda');
    }
}
