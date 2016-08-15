<table>
    <tr>
        <td>size</td>
        {% for name in names %}
            <td>{{ name }}</td>
        {% endfor %}
        <td>winner</td>
    </tr>

    {% for size, part in data %}
        <tr>
            <td>{{ size }}</td>
            {% set winnCount = 0 %}
            {% set winnerName = '=' %}
            {% for name in names %}
                {% if winnCount == 0 or winnCount <= part[name] %}
                    {% if winnCount == part[name] %}
                        {% set winnerName = winnerName~' = '~name %}
                    {% else %}
                        {% set winnerName = name %}
                        {% set winnCount = part[name] %}
                    {% endif %}
                {% endif %}
                <td>{{ part[name] }}</td>
            {% endfor %}
            <td>{{ winnerName }}</td>
        </tr>
    {% endfor %}
</table>