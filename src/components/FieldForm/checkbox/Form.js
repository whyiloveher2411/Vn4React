import { Checkbox, FormControl, FormControlLabel, FormGroup, FormHelperText, FormLabel, Typography } from '@material-ui/core'
import React, { useState } from 'react'

export default React.memo(function CheckboxForm(props) {
    let { config, name, post, onReview } = props;

    let valueInital = [];

    try {
        if (typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post && post[name]) {
                valueInital = JSON.parse(post[name]);
            }
        }
    } catch (error) {
        valueInital = [];
    }

    post[name] = valueInital;

    const [value, setValue] = useState(0);

    const handleOnClick = (e) => {

        let checked = e.target.checked;
        let key = e.target.name;

        if (checked) {
            valueInital.push(key);
        } else {
            let index = valueInital.indexOf(key);
            if (index > -1) {
                valueInital.splice(index, 1);
            }
        }

        post[name] = valueInital;
        onReview(post[name]);
        setValue(value + 1);
    };

    console.log('render CHECKBOX');

    return (
        <FormControl >
            <Typography>{config.title}</Typography>
            <FormGroup>

                {
                    Object.keys(config.list_option).map(key =>
                        <FormControlLabel
                            key={key}
                            control={<Checkbox value={key} onChange={handleOnClick} checked={valueInital && valueInital.indexOf(key) !== -1} color="primary" name={key} />}
                            label={config.list_option[key].title}
                        />
                    )
                }
            </FormGroup>
            {
                Boolean(config.note) &&
                <FormHelperText>{config.note}</FormHelperText>
            }
        </FormControl>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
