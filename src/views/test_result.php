<table>
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

<table>
    <tr>
        <td rowspan="2">size</td>
        {% for name in testArray %}
            <td colspan="3">{{ name }}</td>
        {% endfor %}
    </tr>
    <tr>
        {% for name in testArray %}
            <td>time</td>
            <td>memory</td>
            <td>comment</td>
        {% endfor %}
    </tr>

    {% for size, part in groupData %}
        {% for test in part %}
            <tr>
                <td>{{ size }}</td>
            {% for name in testArray %}
                <td>{{ test[name].time }}</td>
                <td>{{ test[name].memory }}</td>
                <td>{{ test[name].comment }}</td>
            {% endfor %}
            </tr>
        {% endfor %}
    {% endfor %}
</table>