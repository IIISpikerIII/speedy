<table>
    <tr>
        <td rowspan="2">size</td>
        {% for name in names %}
        <td colspan="3">{{ name }}</td>
        {% endfor %}
    </tr>
    <tr>
        {% for name in names %}
        <td>time</td>
        <td>memory</td>
        <td>comment</td>
        {% endfor %}
    </tr>

    {% for size, part in data %}
        {% for test in part %}
        <tr>
            <td>{{ size }}</td>
            {% for name in names %}
            <td>{{ test[name].time }}</td>
            <td>{{ test[name].memory }}</td>
            <td>{{ test[name].comment }}</td>
            {% endfor %}
        </tr>
        {% endfor %}
    {% endfor %}
</table>