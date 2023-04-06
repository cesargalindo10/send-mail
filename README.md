
import React, { useState } from 'react';


function Checbox() {
  const [masterCheckboxChecked, setMasterCheckboxChecked] = useState(false);
  const [secondaryCheckboxesChecked, setSecondaryCheckboxesChecked] = useState({
    checkbox1: false,
    checkbox2: false,
    checkbox3: false,
  });

  const handleMasterCheckboxChange = () => {
    const newState = !masterCheckboxChecked;
    setMasterCheckboxChecked(newState);
    const checkboxes = { ...secondaryCheckboxesChecked };
    Object.keys(checkboxes).forEach(checkbox => {
      checkboxes[checkbox] = newState;
    });
    setSecondaryCheckboxesChecked(checkboxes);
  };

  const handleSecondaryCheckboxChange = (id) => {
    const checkboxes = { ...secondaryCheckboxesChecked };
    checkboxes[id] = !checkboxes[id];
    setSecondaryCheckboxesChecked(checkboxes);
    const allChecked = Object.values(checkboxes).every(checkbox => checkbox === true);
    setMasterCheckboxChecked(allChecked);
  };

  return (
    <div>
      <input type="checkbox" checked={masterCheckboxChecked} onChange={handleMasterCheckboxChange} />
      <label htmlFor="masterCheckbox">Seleccionar todos los checkboxes</label>

      {Object.keys(secondaryCheckboxesChecked).map(id => (
        <div key={id}>
          <input type="checkbox" id={id} checked={secondaryCheckboxesChecked[id]} onChange={() => handleSecondaryCheckboxChange(id)} />
          <label htmlFor={id}>{id}</label>
        </div>
      ))}
    </div>
  );
}
export default Checbox
