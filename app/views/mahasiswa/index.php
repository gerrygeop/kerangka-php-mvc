<div class="container">
    <div class="p-5 rounded border border-2 border-info">
        <div class="row">
            <div class="col-6">
                <?php Flasher::flash(); ?>
            </div>
        </div>

        <a href="<?= BASEURL; ?>/mahasiswa/create" class="btn btn-primary mb-3">Tambah Mahasiswa</a>

        <h3><?= $data['judul']; ?></h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['mhs'] as $mhs) : ?>
                    <tr>
                        <td scope="row">
                            <?= $mhs['id']; ?>
                        </td>
                        <td scope="row">
                            <?= $mhs['nama']; ?>
                        </td>
                        <td scope="row" class="w-50">
                            <a href="<?= BASEURL; ?>/mahasiswa/detail/<?= $mhs['id']; ?>"
                                class="btn btn-success btn-sm"
                            >
                                Detail
                            </a>
                            <a href="<?= BASEURL; ?>/mahasiswa/edit/<?= $mhs['id']; ?>" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                            <a  href="<?= BASEURL; ?>/mahasiswa/delete/<?= $mhs['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin?');"
                            >
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>