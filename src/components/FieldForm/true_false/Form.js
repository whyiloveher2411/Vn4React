import { Checkbox, FormControl, FormControlLabel, FormGroup, FormLabel, Switch, Typography } from '@material-ui/core';
import React from 'react';

export default React.memo(function TrueFalseForm(props) {
    const { config, post, onReview, name, label, inlineEdit } = props;

    const [value, setValue] = React.useState(0);

    let checked = config.defaultValue ? config.defaultValue : false;

    if (typeof post[name] !== 'undefined') {
        if (post[name] * 1) {
            checked = true;
        } else {
            checked = false;
        }
    }

    if (config.isChecked) {
        return <><FormControlLabel
            style={{ marginRight: 24 }}
            control={<Checkbox
                onClick={() => {
                    onReview(checked ? 0 : 1);
                }} checked={Boolean(post[name])} color="primary" />}
            label={config.title}
        />
            {
                Boolean(config.note) &&
                <Typography variant="body2">{config.note}</Typography>
            }
        </>
    }

    return (
        <FormControl component="fieldset">
            <FormLabel component="legend">
                {
                    Boolean(!inlineEdit && config.title) &&
                    config.title
                }
                <FormGroup style={{ display: 'inline' }}>
                    <Switch
                        color="primary"
                        name={name}
                        onChange={e => { setValue(value + 1); post[name] = e.target.checked ? 1 : 0; onReview(e.target.checked ? 1 : 0); }}
                        checked={checked}
                        inputProps={{ 'aria-label': config.title }}
                    />
                </FormGroup>
            </FormLabel>
            <Typography variant="body2">{config.note}</Typography>
        </FormControl>
    )

}, (props1, props2) => {
    return !props1.config.forceRender && props1.post[props1.name] === props2.post[props2.name];
})


