<section class='goods'>
                
                <aside class='cats'>
                    <ul id='cats'>
                        <template id='category'>
                            <li data-id='{{id}}'>
                                <h3>{{title}}</h3>
                                <p>{{description}}</p>
                            </li>    
                        </template>
                    </ul>
                    
                    <form id='search'>
                        <label>
                            <span>Price from:</span>
                            <input type='number' value='0' min='0' id='price_min' />
                        </label>
                        
                        <label>
                            <span>Price to:</span>
                            <input type='number' value='0' min='0' id='price_max' />
                        </label>
                        
                        <input type='submit' value='Search' />
                    </form>
                </aside>
                
                <article>
                    <ul id='items' class='items'>
                        <template id='item'>
                            <li data-id='{{id}}'>
                                <figure>
                                    <img src='{{img}}' />
                                    <figcaption>
                                        <h3>{{title}}</h3>
                                        <p>{{shorthand}}</p>
                                        <div>
                                            <span>Price: {{price}} $</span>
                                            <span>Weight: {{weight}} g</span>
                                            <span>Amount: {{amount}}</span>
                                        </div>
                                    </figcaption>
                                </figure>
                                
                            </li>
                        </template>
                    </ul>
                    <div id='details'>
                        <div>
                            
                        </div>
                        <template id='detail'>
                            <figure>
                                <img src='{{img}}' />
                                <figcaption>
                                    <h3>{{title}}</h3>
                                    <p>{{price}} $</p>
                                    <div>{{description}}</div>
                                </figcaption>
                            </figure>
                        </template>
                        
                        <h2>Similar items: </h2>
                        <ul id='similar' class='items'>
                            
                        </ul>
                    </div>
                </article>
                
            </section>