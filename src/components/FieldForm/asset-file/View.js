import Typography from '@material-ui/core/Typography';
import CardMedia from '@material-ui/core/CardMedia';

import React from 'react';

function View(props) {


    let valueInital = {};

    try {
        if (typeof props.content === 'object') {
            valueInital = props.content;
        } else {
            if (props.content) {
                valueInital = JSON.parse(props.content);
            }
        }
    } catch (error) {
        valueInital = {};
    }

    if (!valueInital) valueInital = {};


    return (
        <>
            {valueInital.link &&
                <div>
                    <div style={{ marginBottom: 5, position: 'relative', display: 'inline-block' }}>
                        <CardMedia
                            style={{ maxWidth: '100%', width: 'auto', cursor: 'pointer' }}
                            component="img"
                            image={'/admin/fileExtension/ico/' + (valueInital.ext.replace(/[^a-zA-Z0-9]/g, "").toLowerCase() + '.jpg')}
                        />
                    </div>
                    <Typography variant="body2" style={{ marginBottom: 16, wordBreak: 'break-all' }}>
                        {unescape(valueInital.link.replace(/^.*[\\/]/, ''))}
                    </Typography>
                </div>
            }
        </>
    )
}

export default View
