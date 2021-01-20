<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section>
    <h1><?= $title;?> rapper</h1>
    <?= \Config\Services::validation()->listErrors(); ?>
<!--    --><?//= set_value('name');?>
    <form method="post" name="rapper_add" action="/store<?= ($id !== null) ? "/".$id : "";?>">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" id="name" value="<?= $rapper['name'];?>" type="text"/>
                </div>
                <div class="form-group mb-2">
                    <label for="label">Label</label>
                    <input class="form-control" name="label" id="label" value="<?= $rapper['label'];?>" type="text"/>
                </div>
                <div class="form-group mb-2">
                    <label for="country">Country</label>
                    <input class="form-control" name="country" id="country" value="<?= $rapper['country'];?>" type="text"/>
                </div>
                <div class="form-group mb-2">
                    <label for="from">First song release date</label>
                    <input class="form-control" name="from" id="from" value="<?= ($rapper['from']!== null)?\DateTime::createFromFormat('d.m.Y', $rapper['from'])->format('Y-m-d'):null;?>" type="date"/>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-2">
                    <label for="genre">Genre</label>
                    <select class="form-control" name="genre" id="genre" value="<?= $rapper['genre'];?>">
                        <option <?= $rapper['genre']=='freestyle' ? 'selected' : '';?>>freestyle</option>
                        <option <?= $rapper['genre']=='gangsta' ? 'selected' : '';?>>gangsta</option>
                        <option <?= $rapper['genre']=='hardcore' ? 'selected' : '';?>>hardcore</option>
                        <option <?= $rapper['genre']=='nerdcore' ? 'selected' : '';?>>nerdcore</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="cool_moves_count" class="">Cool Moves Count</label>
                    <input class="form-control" type="number" min="0"  name="cool_moves_count" id="cool_moves_count" value="<?= $rapper['cool_moves_count'];?>">
                </div>
                <div class="form-group mb-3">
                    <label for="swearing_frequency" class="">Swearing Frequency</label>
                    <input class="form-control" type="number" min="0" max="1" step="any" name="swearing_frequency" id="swearing_frequency" value="<?= $rapper['swearing_frequency'];?>">
                </div>
                <div class="form-group mb-2 pt-4">
                    <select class="form-control" name="dead_baddy" id="genre" value="<?= $rapper['dead_baddy']==='Killed in a fight' ? '1' : '0';?>">
                        <option value="1" <?= $rapper['dead_baddy']=='Killed in a fight' ? 'selected' : '';?>>Killed in a fight</option>
                        <option value="0" <?= $rapper['dead_baddy']=='Killed in a fight' ? '' : 'selected';?>>Not killed in a fight</option>
                    </select>
                </div>
            </div>
            <input class="btn btn-primary mt-4" type="submit" value="<?=$title;?>">
            <a class="btn btn-primary mt-4 ml-5" href="/random<?= ($id !== null) ? "/".$id : "";?>">Random</a>
        </div>
    </form>

</section>
<?= $this->endSection() ?>
