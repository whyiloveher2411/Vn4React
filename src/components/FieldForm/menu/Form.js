import React from 'react';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import CircularProgress from '@material-ui/core/CircularProgress';
import { useAjax } from 'utils/useAjax';

export default React.memo(function RelationshipOneToManyForm(props) {

  console.log('render MENU');

  const { config, post, onReview, name } = props;

  let valueInital = { id: 0, title: '' };

  try {
    if (typeof post[name + '_detail'] === 'object') {
      valueInital = post[name + '_detail'];
    } else {
      if (post[name] && post[name + '_detail']) {
        valueInital = JSON.parse(post[name + '_detail']);
      }
    }
  } catch (error) {
    valueInital = { id: 0, title: '' };
  }

  const {ajax} = useAjax();

  const [open, setOpen] = React.useState(false);
  const [options, setOptions] = React.useState([]);
  const loading = open && options.length === 0;

  React.useEffect(() => {

    if (options.length === 0) {
      let active = true;

      if (!loading) {
        return undefined;
      }

      (async () => {

        ajax({
          url: 'menu/get',
          success: function (result) {
            if (active) {
              setOptions(result.rows);
            }
          }
        });

      })();

      return () => {
        active = false;
      };

    }

  }, [loading]);

  const handleOnChange = (e, value) => {
    onReview(value);
  };
  return (
    <Autocomplete
      open={open}
      onOpen={() => {
        setOpen(true);
      }}
      onClose={() => {
        setOpen(false);
      }}
      value={valueInital || { id: 0, title: '' }}
      defaultValue={valueInital || { id: 0, title: '' }}
      getOptionSelected={(option, value) => option.id === value.id}
      getOptionLabel={(option) => option.title}
      options={options}
      onChange={handleOnChange}
      loading={loading}
      renderInput={(params) => (
        <TextField
          {...params}
          label={config.title}
          variant="outlined"
          InputProps={{
            ...params.InputProps,
            endAdornment: (
              <React.Fragment>
                {loading ? <CircularProgress color="inherit" size={20} /> : null}
                {params.InputProps.endAdornment}
              </React.Fragment>
            ),
          }}
        />
      )}
    />
  );
}, (props1, props2) => {
  return props1.post[props1.name] === props2.post[props2.name];
})
