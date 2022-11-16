package com.example.amicacina;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
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
    //Define a URL em que o corpo POST da requisição de agendamento será enviada.
    public static final String REQUEST_SENDING_URL = "https://amicao.herokuapp.com/api/application_send/send_request";
    TextView txtMessage;

    /*
    O método abaixo inicializa a activity e oculta texto desnecessário da AppBar.
    */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);

        ActionBar actionBar = getSupportActionBar();
        actionBar.setDisplayHomeAsUpEnabled(true);
        actionBar.setTitle("");

        // Define ColorDrawable object and parse color
        // using parseColor method
        // with color hash code as its parameter
        ColorDrawable colorDrawable = new ColorDrawable(Color.parseColor("#e08f60"));

        // Set BackgroundDrawable
        actionBar.setBackgroundDrawable(colorDrawable);
    }

    /*
        O método abaixo é invocado quando o usuário clica no botão para enviar a requisição de agendamento.
        Pois o método primeiramente verifica a conectividade com a internet e notifica o usuário da impossibilidade da
        operação em caso de falta de conectividade.
        Caso a conectividade seja verdadeira, então o método realiza o envio das informações que são validadas no servidor, recebe
        trata e notifica o usuário sobre o status / reposta da operação.
     */
    public void onClickSend(View view) {

        RadioGroup radiogroup = (RadioGroup) findViewById(R.id.radiogroup);
        EditText nome = (EditText) findViewById(R.id.txtUnome);
        EditText email = (EditText) findViewById(R.id.txtUemail);
        EditText telefone = (EditText) findViewById(R.id.txtUtelefone);
        RadioButton selectedReqType = (RadioButton) findViewById(radiogroup.getCheckedRadioButtonId());
        String req_type = "";
        txtMessage = (TextView) findViewById(R.id.txtViewMessage);
        if (selectedReqType.getText().equals("Adotar")) {
            req_type = "adocao";
        } else if (selectedReqType.getText().equals("Apadrinhar")) {
            req_type = "apadrinhamento";
        } else if (selectedReqType.getText().equals("Visitar")) {
            req_type = "visita";
        } else {
            txtMessage.setText("Uma ação deve ser selecionada!");
        }


        if (MainActivity.internet_connection) {
            Ion.with(activity_info.this)
                    .load(REQUEST_SENDING_URL)
                    .setBodyParameter("id_pet", String.valueOf(MainActivity.id_pet))
                    .setBodyParameter("nome", nome.getText().toString())
                    .setBodyParameter("email", email.getText().toString())
                    .setBodyParameter("phone", telefone.getText().toString())
                    .setBodyParameter("obs", "")
                    .setBodyParameter("req_type", req_type)
                    .asJsonObject()
                    .setCallback(new FutureCallback<JsonObject>() {
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

                            } catch (Exception excp) {
                                String sucess = result.get("success").getAsString();
                                if (sucess.equals("request_sent")) {
                                    txtMessage.setText("Agendamento realizado com sucesso, fique atento por mais informações em seu e-mail :)");
                                }
                            }
                        }
                    });
        } else {
            Toast.makeText(activity_info.this, "Seu dispositivo não tem acesso à internet!", Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public boolean onCreateOptionsMenu(Menu menu) {
        return true;
    }
}

