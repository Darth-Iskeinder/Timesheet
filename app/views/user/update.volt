{{ content() }}
<div class=container>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("user/index", "&larr; Go Back") }}
        </li>
    </ul>
{{ form('user/save', 'role': 'form') }}
    <h2>Edit products</h2>

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