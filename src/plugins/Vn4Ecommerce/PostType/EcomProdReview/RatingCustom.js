import { FormControl, Typography } from '@material-ui/core';
import Rating from '@material-ui/lab/Rating';
import React from 'react';

export default function RatingCustom(props) {

    const [render, setRender] = React.useState(0);
    if (props.fieldtype === 'list') {
        return (
            <div>
                <Rating value={props.post[props.name]} readOnly />
            </div>
        )
    }

    return (
        <FormControl size={props.config.size ?? 'medium'} fullWidth variant="outlined">
            <Typography component="legend">{props.config.title}</Typography>
            <Rating onChange={(e, value) => { props.post[props.name] = value; props.onReview(value, props.name); setRender(render + 1); }} name="size-large" value={props.post[props.name] ?? 0} size="large" />
        </FormControl>
    )
}
