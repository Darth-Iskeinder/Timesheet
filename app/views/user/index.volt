{{ content() }}
<div class=container>
    {%- if logged_in is empty -%}
                {{ link_to(
                        'session/logout',
                        'Logout',
                        'class': 'btn btn-primary btn-lg'
                    )
                }}
    {% endif %}
<h1>Welcome to admin panel</h2>
{{ link_to("user/create/", "Create new user") }}
<br>
<br>
{{ link_to("time/create", "Create time for user") }}
<br>
<br>
{{ link_to("holiday/create/", "Create new holiday") }}
{% for user in users %}

<table>
    <tr>
        <td>{{user.name}}</td>
        <td width="7%">
            {{ link_to("time/index/" ~ user.id, "User times") }}
        </td>
                <td width="7%">
                </td>
        <td width="7%">
            {{ link_to("user/update/" ~ user.id, "Edit") }}
        </td>
        <td width="7%">
            {{ link_to("user/delete/" ~ user.id, "Deactivate") }}
        </td>
        <td width="7%">
             {% for time in userTime %}
                {% if user.id == time.userId %}
                    {{ time.startTime }}
<!--                     {% if time.year == year %} -->
<!--                         {% if time.month == month %} -->
<!--                             {% if time.day == day %} -->
<!--                                 {{ time.startTime }} -->
<!--                             {% endif %} -->
<!--                         {% endif %} -->
<!--                     {% endif %} -->
                {% endif %}
             {% endfor %}
        </td>

    </tr>
</table>
{% endfor %}
</div>
