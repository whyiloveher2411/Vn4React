import { Chip } from '@material-ui/core';
import React from 'react';
import { NavLink } from 'react-router-dom';

function View({ post = null, name }) {

    if (post[name]) {
        try {

            const postJson = JSON.parse(post[name]);

            return (
                <div>
                    {
                        postJson.map(item => (
                            <Chip
                                style={{ textTransform: 'none', fontWeight: 'normal', margin: 2 }}
                                label={postJson.title}
                                onClick={e => e.stopPropagation()}
                                component={NavLink}
                                to={`/post-type/${item.type}/edit?post_id=${item.id}`}
                            />

                            // <Button
                            //     key={item.id}
                            //     variant="contained"
                            //     style={{ textTransform: 'none', fontWeight: 'normal', margin: 2 }}
                            //     onClick={e => e.stopPropagation()}
                            //     color='default'
                            //     component={NavLink}
                            //     to={`/post-type/${item.type}/edit?post_id=${item.id}`}>
                            //     {item.title}
                            // </Button>
                        ))
                    }

                </div>
            )
        } catch (error) {

        }
    }

    return '';
}

export default View
