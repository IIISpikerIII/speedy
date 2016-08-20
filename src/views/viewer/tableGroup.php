<table class="table table-bordered">
    <tr>
        <td rowspan="2">size</td>
        {% for name in names %}
        <td colspan="3">{{ name }}</td>
        {% endfor %}
        <td rowspan="2">comment</td>
        <td rowspan="2">time win</td>
    </tr>
    <tr>
        {% for name in names %}
        <td>time</td>
        <td>%</td>
        <td>memory</td>
        {% endfor %}
    </tr>

    {% for size, part in data %}
        {% for numPart, test in part %}
        <tr>
            <td>{{ size }}</td>
            {% set winnerTime = 0 %}
            {% set winnerName = '=' %}
            {% set commentRow = '' %}
            {% for name in names %}
                {% set commentRow = test[name].comment %}
                {% if winnerTime == 0 or winnerTime >= test[name].time %}
                    {% if winnerTime == test[name].time %}
                        {% set winnerName = winnerTime~' = '~test[name].name %}
                    {% else %}
                        {% set winnerName = test[name].name %}
                        {% set winnerTime = test[name].time %}
                    {% endif %}
                {% endif %}
                <td>{{ test[name].time }}</td>

                {% set percentTime = (((stat[size][numPart]['maxTime'] - test[name].time)/(stat[size][numPart]['maxTime']))*100) |round(2) %}
                {% if percentTime == 0 %}
                    <td class="danger"></td>
                {% else %}
                    <td>{{ percentTime }}</td>
                {% endif %}

                <td>{{ test[name].memory }}</td>
            {% endfor %}
            <td>{{ commentRow }}</td>
            <td>{{ winnerName }}</td>
        </tr>
        {% endfor %}
    {% endfor %}
</table>