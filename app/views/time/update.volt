{{ content() }}
<div class=container>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("time/index/" ~ userId, "Go back") }}
        </li>
    </ul>
{{ form('time/save', 'role': 'form') }}
    <h2>Edit user time</h2>

    <fieldset>
        {% for element in form %}

                <div class="form-group">
                    {{ element.label() }}
                    {{ element.render(['class': 'form-control']) }}
                </div>

        {% endfor %}
        <div class="form-group">
                    {{ submit_button('Save', 'class': 'btn btn-primary btn-large') }}
                </div>
    </fieldset>
    </div>
{{  endform() }}