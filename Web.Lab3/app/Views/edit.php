<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section>

    <h1>Edit rapper</h1>

    <?= \Config\Services::validation()->listErrors(); ?>

    <form method="post" name="rapper_add" action="/store/<?= $rapper['id'];?>">
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
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select class="form-control form-control-sm" name="genre" id="genre" value="<?= $rapper['genre'];?>">
                        <option <?= $rapper['genre']=='freestyle' ? 'selected' : '';?>>freestyle</option>
                        <option <?= $rapper['genre']=='gangsta' ? 'selected' : '';?>>gangsta</option>
                        <option <?= $rapper['genre']=='hardcore' ? 'selected' : '';?>>hardcore</option>
                        <option <?= $rapper['genre']=='nerdcore' ? 'selected' : '';?>>nerdcore</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cool_moves_count" class="col-2 col-form-label">Cool Moves Count</label>
                    <div class="col-10">
                        <input class="form-control" type="number" min="0" name="cool_moves_count" id="cool_moves_count"
                               value="<?= $rapper['cool_moves_count'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="swearing_frequency" class="col-2 col-form-label">Swearing Frequency</label>
                    <div class="col-10">
                        <input class="form-control" type="number" step="any" min="0" max="1" name="swearing_frequency"
                               id="swearing_frequency" value="<?= $rapper['swearing_frequency'];?>">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check mb-2 mr-sm-2">
                    <select class="form-control form-control-sm" name="dead_baddy" id="genre" value="<?= $rapper['dead_baddy']==='Killed in a fight' ? '1' : '0';?>">
                        <option value="1" <?= $rapper['dead_baddy']=='Killed in a fight' ? 'selected' : '';?>>Killed in a fight</option>
                        <option value="0" <?= $rapper['dead_baddy']=='Killed in a fight' ? '' : 'selected';?>>Not killed in a fight</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="from">First song release date</label>
                    <input class="form-control" name="from" id="from" value="<?= \DateTime::createFromFormat('d.m.Y', $rapper['from'])->format('Y-m-d');?>" type="date"/>
                </div>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Edit rapper">
            </div>
            <a class="btn btn-warning" href="/random/<?= $rapper['id'];?>">Random</a>
        </div>
    </form>


</section>
<?= $this->endSection() ?>
