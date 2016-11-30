<h2>Website blog</h2>
<ul id='news'>
    <template id='article'>
        <li data-id='{{id}}'>
            <figure>
                <img src='{{img}}'/>
                <figcaption>
                    <h3>{{title}}</h3>
                    <time>{{published}}</time>
                    <p>{{shorthand}}</p>
                </figcaption>
            </figure>
        </li>
    </template>
</ul>

<div id='articleContents'>
    <a href='#news'>Back to blog</a>
    <div>
        
        <template id='articleContent'>
            <figure>
                <img src='{{img}}'/>
                <figcaption>
                    <h3>{{title}}</h3>
                    <div>
                        {{content}}
                    </div>
                </figcaption>
            </figure>
        </template>
    </div>
</div>