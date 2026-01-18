function loadBorrows(){
    $.get('index.php?c=borrow&a=api&action=list',res=>{
        let h='';
        res.data.forEach((b,i)=>{
            let statusBadge = b.status === 'BORROWED'
                ? `<span class="badge-status-borrowed">Chưa trả</span>`
                : `<span class="badge-status-returned">Đã trả</span>`;

            h+=`<tr>
                    <td>${i+1}</td>
                    <td>${b.full_name}</td>
                    <td>${b.title}</td>
                    <td>${b.borrow_date}</td>
                    <td>${b.due_date}</td>
                    <td>${statusBadge}</td>
                    <td>
                        ${b.status==='BORROWED'
                        ? `<button class="btn btn-sm btn-outline-danger" onclick="returnBook(${b.id})">Trả</button>`
                        : ''}
                    </td>
                </tr>`;
        });
        $('#borrowBody').html(h);
    },'json');
}

function loadSelects(){
    // load members
    $.get('index.php?c=member&a=api&action=list',res=>{
        let opts = '<option value="">--Chọn độc giả--</option>';
        res.data.forEach(m=>{
            opts += `<option value="${m.id}">${m.full_name} (${m.member_code})</option>`;
        });
        $('#member_id').html(opts);
    },'json');

    // load books (only show those with quantity>0)
    $.get('index.php?c=book&a=api&action=list',res=>{
        let opts = '<option value="">--Chọn sách--</option>';
        res.data.forEach(b=>{
            if(+b.quantity > 0) opts += `<option value="${b.id}">${b.title} (${b.quantity})</option>`;
        });
        $('#book_id').html(opts);
    },'json');
}

$('#borrowForm').submit(e=>{
    e.preventDefault();
    $.post('index.php?c=borrow&a=api&action=create',
        $('#borrowForm').serialize(),
        (res)=>{
            if(!res || !res.success){
                alert(res && res.message ? res.message : 'Lỗi khi mượn sách');
                return;
            }
            $('#borrowForm')[0].reset();
            loadSelects();
            loadBorrows();
        },'json');
});

// reset borrow form
$('#resetBorrow').on('click', ()=>{ $('#borrowForm')[0].reset(); });

function returnBook(id){
    $.post('index.php?c=borrow&a=api&action=return',{id},loadBorrows,'json');
}

loadBorrows();
loadSelects();
