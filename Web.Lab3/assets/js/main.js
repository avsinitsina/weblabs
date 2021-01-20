$(document).ready(function(){
    get_page();
    init_filter();
});
function init_filter(){
    $('#filter').on('submit', function(e){
        e.preventDefault();
        $(this).data('filter', JSON.stringify($(this).serializeArray()));
        get_page();
    })
}
function load_list(result){
    pgr = $('.pager').html(result.pager);
    pgr.find('a').one('click', function(e){
        e.preventDefault();
        get_page($(this).attr('href'));
    });
    stylize(pgr);
    $('table.rappers tbody').html("");
    result.rappers.forEach(function(item){
        str = `<tr>
                <td>${item.name}</td>
                <td>${item.genre}</td>
                <td>${item.label}</td>
                <td>${item.country}</td>
                <td>${item.from}</td>
                <td>${item.dead_baddy}</td>
                <td>${item.cool_moves_count}</td>
                <td>${item.swearing_frequency}</td>
                <td><button type='button' class="kek" onclick="deleteRec(${item.id})">Delete</button></td>
                <td><a role='button' class=$("btn btn-warning") href="/edit/${item.id}">Edit</a></td>
            </tr>`
        $('table.rappers tbody').append(str)
    })
    stylizeTable();
}
function deleteRec(id) {
    $.post("/delete/" + id);
    get_page();
}
function get_page(page = '/list/1'){
    $.post(page,{filter: $('#filter').data('filter')}, function(result){
        load_list(result);
    });
}
function stylize(element){
    element.find('a').addClass("page-link");
    element.find('li').addClass("page-item");
}

function stylizeTable() {
    $('table.rappers tbody').find('a').addClass("btn btn-warning");
    $('table.rappers tbody').find('button').addClass("btn btn-warning");
}