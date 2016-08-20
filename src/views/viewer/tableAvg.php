<table class="table table-bordered">
    <tr>
        <td rowspan="2">size</td>
        {% for name in names %}
            <td colspan="2">{{ name }}</td>
        {% endfor %}
        <td rowspan="2">winner</td>
    </tr>
    <tr>
        {% for name in names %}
            <td>winns</td>
            <td>%</td>
        {% endfor %}
    </tr>

    {% for size, part in data %}
        <tr>
            <td>{{ size }}</td>
            {% set winnCount = 0 %}
            {% set winnerName = '=' %}
            {% for name in names %}
                {% if winnCount == 0 or winnCount <= part[name]['count'] %}
                    {% if winnCount == part[name]['count']  %}
                        {% set winnerName = winnerName~' = '~name %}
                    {% else %}
                        {% set winnerName = name %}
                        {% set winnCount = part[name]['count']  %}
                    {% endif %}
                {% endif %}
                <td>{{ part[name]['count']  }}</td>
                {% if part[name]['percent'] == 0 %}
                    <td class="danger"></td>
                {% else %}
                    <td>{{ part[name]['percent'] |round(2)}}</td>
                {% endif %}
            {% endfor %}
            <td>{{ winnerName }}</td>
        </tr>
    {% endfor %}
</table>