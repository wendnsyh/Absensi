<form method="post" action="<?= base_url('absensi/update_status'); ?>">
    <input type="hidden" name="id" value="<?= $absen->id; ?>">

    <label>Status:</label>
    <select name="status" class="form-control">
        <option value="HADIR">Hadir</option>
        <option value="SAKIT">Sakit</option>
        <option value="IZIN">Izin</option>
        <option value="ALPA">Tanpa Keterangan</option>
    </select>

    <button class="btn btn-primary mt-2">Simpan</button>
</form>