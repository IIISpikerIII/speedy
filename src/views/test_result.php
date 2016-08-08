<table>
    <tr>
        <td>name</td>
        <td>time</td>
        <td>size</td>
        <td>comment</td>
    </tr>
    {% for row in data %}
        <tr>
            <td>{{ row.name }}</td>
            <td>{{ row.time }}</td>
            <td>{{ row.size }}</td>
            <td>{{ row.comment }}</td>
        </tr>
    {% endfor %}
</table>