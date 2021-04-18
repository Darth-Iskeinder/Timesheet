{{ content() }}
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            {{ link_to("user/index", "Go Back") }}
        </li>
    </ul>
<div class="page-header">
    <h3>Create time for user</h3>
</div>
{{ form('time/create') }}

    <fieldset>

            {% for element in form %}
                <div class='control-group'>
                    {{ element.label(['class': 'control-label']) }}

                    <div class='controls'>
                        {{ element }}
                    </div>
                </div>
            {% endfor %}



            <div class='control-group'>
                {{ submit_button('Save', 'class': 'btn btn-primary') }}
            </div>

        </fieldset>
    </div>
{{  endform() }}