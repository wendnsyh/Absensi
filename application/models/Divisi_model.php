<?php
class Divisi_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->order_by('id_divisi', 'ASC')->get('divisi')->result();
        // MUST return object
    }

    public function insert($data)
    {
        return $this->db->insert('divisi', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_divisi', $id);
        return $this->db->update('divisi', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_divisi', $id);
        return $this->db->delete('divisi');
    }
}
