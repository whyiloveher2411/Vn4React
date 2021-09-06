/* eslint-disable no-use-before-define */
import React from 'react';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';

export default function Timezone(props) {

    const { post, name, onReview } = props;

    let account = post.account;

    let valueIitial = {};

    let optionsInitial = [];

    if (account.items) {
        optionsInitial = account.items.map((element) => {

            const group = element.webproperties.items.map(element2 => {

                if (`["${element2.defaultProfileId}","${element2.name}","${element2.websiteUrl}"]` === post[name]) {
                    valueIitial = {
                        title: element2.name,
                        value: `["${element2.defaultProfileId}","${element2.name}","${element2.websiteUrl}"]`,
                        filter: element.name
                    };
                }

                return {
                    title: element2.name,
                    value: `["${element2.defaultProfileId}","${element2.name}","${element2.websiteUrl}"]`,
                    filter: element.name
                };

            });

            return group;

        });
    }

    let optionsInitial2 = [];

    optionsInitial.forEach((item, index) => {
        optionsInitial2 = optionsInitial2.concat(item);
    });

    const options = optionsInitial2;

    const [value, setValue] = React.useState(0);

    const handleOnChange = (e, option) => {
        console.log(option);
        if (option) {
            onReview(option.value); setValue(value + 1);
        } else {
            onReview(''); setValue(value + 1);
        }
    };

    return (
        <Autocomplete
            fullWidth
            options={options}
            onChange={handleOnChange}
            getOptionSelected={(option, value) => option.value === value.value}
            defaultValue={valueIitial}
            value={valueIitial}
            groupBy={(option) => option.filter}
            getOptionLabel={(option) => option?.title ?? ''}
            renderInput={(params) => <TextField {...params} label="Webproperties" fullWidth variant="outlined" />}
        />
    );
}
