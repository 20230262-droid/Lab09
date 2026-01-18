function loadBooks(){
    $.get('index.php?c=book&a=api&action=list',res=>{
        let h='';
        res.data.forEach((b,i)=>{
            h+=`<tr>
                <td>${i+1}</td>
                <td>${b.isbn}</td>
                <td>${b.title}</td>
                <td>${b.author}</td>
                <td>${b.quantity}</td>
                <td>
                    <button onclick='edit(${JSON.stringify(b)})'>Sửa</button>
                    <button onclick='del(${b.id})'>Xóa</button>
                </td>
            </tr>`;
        });
        $('#bookBody').html(h);
    },'json');
}

// 'Thêm' button: clear the form for adding a new book
$('#addBtn').click(()=>{
    $('#bookForm')[0].reset();
    $('#id').val('');
    $('[name=title]').focus();
});

// reset buttons for views
$('#resetBook').on('click', ()=>{ $('#bookForm')[0].reset(); $('#id').val(''); });

$('#bookForm').submit(e=>{
    e.preventDefault();
    let act = $('#id').val()?'update':'create';
    $.post(`index.php?c=book&a=api&action=${act}`,
        $('#bookForm').serialize(),(res)=>{
            if(!res || !res.success){
                alert(res && res.message ? res.message : 'Lỗi khi lưu sách');
                return;
            }
            $('#bookForm')[0].reset();
            loadBooks();
        },'json');
});

function edit(b){
    for(let k in b) $(`[name=${k}]`).val(b[k]);
}

function del(id){
    if(confirm('Xóa?'))
        $.post('index.php?c=book&a=api&action=delete',{id},loadBooks,'json');
}

loadBooks();
