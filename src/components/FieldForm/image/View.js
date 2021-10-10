import { CardMedia, GridList, GridListTile } from '@material-ui/core';
import React from 'react';

function View(props) {

    console.log(props);

    if (props.config.multiple) {


        let valueInital = [];

        try {
            if (typeof props.content === 'object') {
                valueInital = props.content;
            } else {
                if (props.content) {
                    valueInital = JSON.parse(props.content);
                }
            }
        } catch (error) {
            valueInital = [];
        }

        if (!valueInital) valueInital = [];


        return <GridList className="custom_scroll" style={{ maxWidth: 200, flexWrap: 'nowrap' }} cols={1}>
            {valueInital.map((image, index) => (
                <GridListTile style={{ width: 160 }} key={index}>
                    <img src={image.type_link === 'local' ? process.env.REACT_APP_BASE_URL + image.link : image.link} alt={'Image'} />
                </GridListTile>
            ))}
        </GridList>;
    }


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
                            style={{ width: 88, height: 50, maxWidth: '100%', maxHeight: 50, objectFit: 'contain', cursor: 'pointer' }}
                            component="img"
                            image={valueInital.type_link === 'local' ? process.env.REACT_APP_BASE_URL + valueInital.link : valueInital.link}
                        />
                    </div>
                </div>
            }
        </>
    )
}

export default View
