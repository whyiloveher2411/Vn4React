import Chip from '@material-ui/core/Chip';
import React from 'react';
import { NavLink } from 'react-router-dom';

function View({ post = null, name }) {

    if (post[name + '_detail']) {
        try {

            const postJson = JSON.parse(post[name + '_detail']);

            return <Chip
                label={postJson.title}
                onClick={e => e.stopPropagation()}
                component={NavLink}
                to={`/post-type/${postJson.type}/edit?post_id=${postJson.id}`}
            />

            // return (
            //     <div>
            //         <Button
            //             variant="contained"
            //             style={{ textTransform: 'none', fontWeight: 'normal' }}
            //             onClick={e => e.stopPropagation()}
            //             component={NavLink}
            //             to={`/post-type/${postJson.type}/edit?post_id=${postJson.id}`}>
            //             {postJson.title}
            //         </Button>
            //     </div>
            // )
        } catch (error) {

        }
    }

    return '';
}

export default View
