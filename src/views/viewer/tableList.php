<table class="table table-bordered">
    <tr>
        <td>name</td>
        <td>time</td>
        <td>size</td>
        <td>memory</td>
        <td>part</td>
        <td>comment</td>
    </tr>
    {% for row in data %}
    <tr>
        <td>{{ row.name }}</td>
        <td>{{ row.time }}</td>
        <td>{{ row.size }}</td>
        <td>{{ row.memory }}</td>
        <td>{{ row.part }}</td>
        <td>{{ row.comment }}</td>
    </tr>
    {% endfor %}
</table>