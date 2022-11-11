package com.example.amicacina;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

import org.w3c.dom.Text;

import java.util.Calendar;
import java.util.Locale;

public class activity_info extends AppCompatActivity {
    private DatePickerDialog datePickerDialog;
    private Button dateButton;
    Button timeButton;
    int hour, minute;
    String datetime_str, today_date;
    public static final String REQUEST_SENDING_URL = "https://amicao.herokuapp.com/api/application_send/send_request";
    TextView txtMessage;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);
        initDatePicker();

        dateButton = findViewById(R.id.datePickerButton);
        dateButton.setText(getTodaysDate());
        timeButton = findViewById(R.id.timeButton);

        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();
    }


    public void popTimePicker(View view)
    {
        TimePickerDialog.OnTimeSetListener onTimeSetListener = new TimePickerDialog.OnTimeSetListener()
        {
            @Override
            public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute)
            {
                hour = selectedHour;
                minute = selectedMinute;
                timeButton.setText(String.format(Locale.getDefault(), "%02d:%02d",hour, minute));
            }
        };


        TimePickerDialog timePickerDialog = new TimePickerDialog(this, onTimeSetListener, hour, minute, true);

        timePickerDialog.setTitle("Select Time");
        timePickerDialog.show();
    }


    private String getTodaysDate()
    {
        Calendar cal = Calendar.getInstance();
        int year = cal.get(Calendar.YEAR);
        int month = cal.get(Calendar.MONTH);
        month = month + 1;
        int day = cal.get(Calendar.DAY_OF_MONTH);

        today_date = makeDateString(day, month, year);
        return makeDateString(day, month, year);
    }

    private void initDatePicker()
    {
        DatePickerDialog.OnDateSetListener dateSetListener = new DatePickerDialog.OnDateSetListener()
        {
            @Override
            public void onDateSet(DatePicker datePicker, int year, int month, int day)
            {
                month = month + 1;
                String date = makeDateString(day, month, year);
                dateButton.setText(date);
            }
        };

        Calendar cal = Calendar.getInstance();
        int year = cal.get(Calendar.YEAR);
        int month = cal.get(Calendar.MONTH);
        int day = cal.get(Calendar.DAY_OF_MONTH);

        int style = AlertDialog.THEME_HOLO_LIGHT;

        datePickerDialog = new DatePickerDialog(this, style, dateSetListener, year, month, day);


    }

    private String makeDateString( int day, int month, int year)
    {
        return  day +  " " + getMonthFormat(month) + " " + year;
    }

    private String getMonthFormat(int month)
    {
        if(month == 1)
            return "JAN";
        if(month == 2)
            return "FEV";
        if(month == 3)
            return "MAR";
        if(month == 4)
            return "ABR";
        if(month == 5)
            return "MAI";
        if(month == 6)
            return "JUN";
        if(month == 7)
            return "JUL";
        if(month == 8)
            return "AGO";
        if(month == 9)
            return "SET";
        if(month == 10)
            return "OUT";
        if(month == 11)
            return "NOV";
        if(month == 12)
            return "DEZ";

        return "JAN";
    }

    public void openDatePicker(View view)
    {
        datePickerDialog.show();
    }

    public void onClickSend(View view){

        RadioGroup radiogroup = (RadioGroup) findViewById(R.id.radiogroup);
        EditText nome = (EditText) findViewById(R.id.txtUnome);
        EditText email = (EditText) findViewById(R.id.txtUemail);
        EditText telefone = (EditText) findViewById(R.id.txtUtelefone);
        RadioButton selectedReqType = (RadioButton) findViewById(radiogroup.getCheckedRadioButtonId());
        String req_type="";
        txtMessage = (TextView)findViewById(R.id.txtViewMessage);
        if(selectedReqType.getText().equals("Adotar")){
            req_type = "adocao";
        }
        else if(selectedReqType.getText().equals("Apadrinhar")){
            req_type = "apadrinhamento";
        }
        else if(selectedReqType.getText().equals("Visitar")){
            req_type = "visita";
        }
        else{
            txtMessage.setText("Uma ação deve ser selecionada!");
        }

        if(timeButton.getText()!=null && timeButton.getText()!=""){
            datetime_str = today_date + "" + timeButton.getText();
            Log.d("date", datetime_str);
            Ion.with (activity_info.this)
                    .load(REQUEST_SENDING_URL)
                    .setBodyParameter("id_pet", String.valueOf(MainActivity.id_pet))
                    .setBodyParameter("nome", nome.getText().toString())
                    .setBodyParameter("email", email.getText().toString())
                    .setBodyParameter("phone", telefone.getText().toString())
                    .setBodyParameter("obs", "")
                    .setBodyParameter("datetime", datetime_str)
                    .setBodyParameter("req_type", req_type)
                    .asJsonObject()
                    .setCallback ( new FutureCallback<JsonObject>() {
                        @Override
                        public void onCompleted(Exception e, JsonObject result) {
                            try {
                                String error = result.get("error").getAsString();

                                switch (error) {
                                    case "invalid_date":
                                        txtMessage.setText("A data informada é inválida!");
                                        break;
                                    case "invalid_email":
                                        txtMessage.setText("O e-email informado é inválido!");
                                        break;
                                    case "invalid_name":
                                        txtMessage.setText("Um nome válido deve ser informado!");
                                        break;
                                    case "invalid_phone":
                                        txtMessage.setText("Um número de celular ou de telefone válido deve ser informado!");
                                        break;
                                    case "invalid_request_type":
                                        txtMessage.setText("Um dado foi perceptívelmente modificado, e possivelmente via código fonte. " +
                                                "Pois alterar o código fonte de Aplicativos e Softwares sem a permissão legal do proprietário, infringe os direitos legais sujeito " +
                                                "à pena da LEI Nº 9.609 /1998 artigo 13");
                                        break;
                                    case "invalid_id":
                                        txtMessage.setText("Um dado foi perceptívelmente modificado, e possivelmente via código fonte. " +
                                                "Pois alterar o código fonte de Aplicativos e Softwares sem a permissão legal do proprietário, infringe os direitos legais sujeito " +
                                                "à pena da LEI Nº 9.609 /1998 artigo 13");
                                        break;
                                }
                                Log.d("error", error);
                                Log.d("id", String.valueOf(MainActivity.id_pet));

                            }catch (Exception excp){
                                String sucess = result.get("success").getAsString();
                                if(sucess.equals("request_sent")){
                                    txtMessage.setText("Agendamento realizado com sucesso, fique atento por mais informações em seu e-mail :)");
                                }
                            }
                        }
                    });

        }
        else{
            txtMessage.setText("Um horário deve ser selecionado!");
        }


    }

}

