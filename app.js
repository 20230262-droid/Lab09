$(function () {

    loadStudents();

    function loadStudents() {
        $.get('index.php?api=1&action=list', function (res) {
            let html = '';

            if (!res.data || res.data.length === 0) {
                html = '<tr><td colspan="6">Chưa có dữ liệu</td></tr>';
            } else {
                res.data.forEach((s, i) => {
                    html += `
                    <tr data-id="${s.id}">
                        <td>${i + 1}</td>
                        <td>${s.code}</td>
                        <td>${s.full_name}</td>
                        <td>${s.email}</td>
                        <td>${s.dob ?? ''}</td>
                        <td>
                            <button class="edit">Sửa</button>
                            <button class="delete">Xóa</button>
                        </td>
                    </tr>`;
                });
            }

            $('#student-list').html(html);
        }, 'json');
    }

    $('#student-form').submit(function (e) {
        e.preventDefault();

        const action = $('#id').val() ? 'update' : 'create';

        $.post(
            'index.php?api=1&action=' + action,
            $(this).serialize(),
            function (res) {
                if (res.success) {
                    loadStudents();
                    $('#student-form')[0].reset();
                    $('#id').val('');
                } else {
                    alert(res.message);
                }
            },
            'json'
        );
    });

    $(document).on('click', '.delete', function () {
        if (!confirm('Bạn chắc chắn muốn xóa?')) return;

        const id = $(this).closest('tr').data('id');

        $.post(
            'index.php?api=1&action=delete',
            { id: id },
            function () {
                loadStudents();
            },
            'json'
        );
    });

    $(document).on('click', '.edit', function () {
        const row = $(this).closest('tr');
        $('#id').val(row.data('id'));
        $('#code').val(row.children().eq(1).text());
        $('#full_name').val(row.children().eq(2).text());
        $('#email').val(row.children().eq(3).text());
        $('#dob').val(row.children().eq(4).text());
    });

});
