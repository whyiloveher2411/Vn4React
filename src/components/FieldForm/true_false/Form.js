import { FormControl, FormGroup, FormLabel, Switch, Typography } from '@material-ui/core';
import React from 'react';

export default React.memo(function TrueFalseForm(props) {
    const { config, post, onReview, name, inlineEdit } = props;

    const [value, setValue] = React.useState(0);

    let checked = config.defaultValue ? config.defaultValue : false;
    if (typeof post[name] !== 'undefined') {
        if (post[name] * 1) {
            checked = true;
        } else {
            checked = false;
        }
    }

    return (
        <FormControl component="fieldset">
            {
                Boolean(!inlineEdit && config.title) &&
                <FormLabel component="legend">{config.title}</FormLabel>
            }
            <Typography variant="body2">{config.note}</Typography>
            <FormGroup>
                <Switch
                    color="primary"
                    name={name}
                    onChange={e => { setValue(value + 1); post[name] = e.target.checked ? 1 : 0; onReview(e.target.checked ? 1 : 0); }}
                    checked={checked}
                    inputProps={{ 'aria-label': config.title }}
                />
            </FormGroup>
        </FormControl>
    )

}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})


