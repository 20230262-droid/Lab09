function loadMembers() {
    $.get('index.php?c=member&a=api&action=list', function (res) {

        let html = '';

        if (res.data.length === 0) {
            html = '<tr><td colspan="6">Chưa có dữ liệu</td></tr>';
        }

        res.data.forEach((m, i) => {
            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${m.member_code}</td>
                    <td>${m.full_name}</td>
                    <td>${m.email}</td>
                    <td>${m.phone ?? ''}</td>
                    <td>
                        <button onclick="editMember(${m.id},
                            '${m.member_code}',
                            '${m.full_name}',
                            '${m.email}',
                            '${m.phone ?? ''}'
                        )">Sửa</button>
                        <button onclick="deleteMember(${m.id})">Xóa</button>
                    </td>
                </tr>`;
        });

        $('#memberBody').html(html);

    }, 'json');
}

$('#memberForm').submit(function (e) {
    e.preventDefault();

    $('.error').text('');

    let action = $('#id').val() ? 'update' : 'create';

    $.post(
        `index.php?c=member&a=api&action=${action}`,
        $(this).serialize(),
        function (res) {

            if (!res.success) {
                if (res.errors) {
                    if (res.errors.member_code) $('#err_member_code').text(res.errors.member_code);
                    if (res.errors.full_name) $('#err_full_name').text(res.errors.full_name);
                    if (res.errors.email) $('#err_email').text(res.errors.email);
                }
                return;
            }

            $('#memberForm')[0].reset();
            $('#id').val('');
            loadMembers();
        },
        'json'
    );
});

// reset member form
$('#resetMember').on('click', ()=>{ $('#memberForm')[0].reset(); $('#id').val(''); $('.error').text(''); });

function editMember(id, code, name, email, phone) {
    $('#id').val(id);
    $('#member_code').val(code);
    $('#full_name').val(name);
    $('#email').val(email);
    $('#phone').val(phone);
}

function deleteMember(id) {
    if (!confirm('Bạn có chắc muốn xóa?')) return;

    $.post(
        'index.php?c=member&a=api&action=delete',
        { id },
        loadMembers,
        'json'
    );
}

loadMembers();
