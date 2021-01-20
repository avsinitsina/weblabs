    <?=form_open('form')?> 
        <div class="form-row align-items-center pt-3 pl-3">
            <div class="col-auto">
                <label for="inlineFormInput">Размер матрицы: </label>
            </div>
            <div class="col-auto">
                <input min="2" max="16" name="size" style="width: 170px;" type="number" class="form-control mb-2" id="inlineFormInput" placeholder="От 2 до 16">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Отправить</button>
            </div>
        </div>
    </form>
</form>
