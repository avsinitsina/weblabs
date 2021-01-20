<?php echo form_open_multipart('upload');?>
    <div class="form-row align-items-center pt-3 pl-3">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <div class="col-auto">
                    <label for="inlineFormInput">Отправить этот файл: </label>
                </div>
                <div class="col-auto">
                    <input name="usermatrix" type="file" class="form-control mb-2" id="inlineFormInput">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Загрузить матрицу</button>
                </div>
    </div>
</form>