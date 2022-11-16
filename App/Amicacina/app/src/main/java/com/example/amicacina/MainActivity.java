package com.example.amicacina;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import android.content.Context;
import android.content.Intent;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.gson.JsonArray;
import com.google.gson.JsonNull;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

public class MainActivity extends AppCompatActivity {

    public static final String GET_DATA_URL = "https://amicao.herokuapp.com/application_retrieve/pets";
    public static Fragment selectedFragment = null;
    public static int id_pet;
    public static int pos;
    public static Boolean from_fav;
    public static Boolean null_data;
    public static Boolean null_fav;
    public static Boolean internet_connection;
    public static String first_run;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();

        null_data=false;
        from_fav=false;
        null_fav=false;
        DatabaseController db = new DatabaseController(MainActivity.this);

        BottomNavigationView bottomNavigationview = (BottomNavigationView)findViewById(R.id.bottomNavigationview);

        for(int i=0; i<bottomNavigationview.getMenu().size(); i++){
            bottomNavigationview.getMenu().getItem(i).setEnabled(false);
        }

        ConnectivityManager connectivityManager = (ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        if(connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == NetworkInfo.State.CONNECTED ||
                connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_WIFI).getState() == NetworkInfo.State.CONNECTED) {
            //we are connected to a network
            internet_connection = true;
        }
        else
            internet_connection = false;

        if(internet_connection) {
            if(db.isRefreshTime() || first_run==null) {
                Ion.with(MainActivity.this)
                        .load(GET_DATA_URL)
                        .asJsonArray()
                        .setCallback(new FutureCallback<JsonArray>() {
                            @Override
                            public void onCompleted(Exception e, JsonArray result) {

                                if (result.isJsonNull()) {
                                    MainActivity.null_data = true;
                                } else {
                                    MainActivity.null_data = false;
                                    db.refreshSyncData();
                                    for (int i = 0; i < result.size(); i++) {
                                        JsonObject res_json = result.get(i).getAsJsonObject();
                                        Log.d("data", res_json.get("id").getAsString());
                                        String comportamentox, nascimentox;

                                        if (res_json.get("comportamento") == JsonNull.INSTANCE) {
                                            comportamentox = "";
                                        } else {
                                            comportamentox = res_json.get("comportamento").getAsString();
                                        }
                                        if (res_json.get("nascimento") == JsonNull.INSTANCE) {
                                            nascimentox = "";
                                        } else {
                                            nascimentox = res_json.get("nascimento").getAsString();

                                        }

                                        db.syncData(
                                                res_json.get("id").getAsInt(),
                                                res_json.get("nome").getAsString(),
                                                res_json.get("img_path").getAsString(),
                                                comportamentox,
                                                res_json.get("status").getAsString(),
                                                res_json.get("raca").getAsString(),
                                                res_json.get("porte").getAsString(),
                                                res_json.get("endereco").getAsString(),
                                                nascimentox,
                                                "false",
                                                res_json.get("idade").getAsString(),
                                                res_json.get("genero").getAsString()
                                        );
                                        getSupportFragmentManager().beginTransaction()
                                                .replace(R.id.fragment_layout, new fragment_home()).commit();

                                        Ion.getDefault(MainActivity.this).cancelAll(MainActivity.this);
                                        for (int x = 0; x < bottomNavigationview.getMenu().size(); x++) {
                                            bottomNavigationview.getMenu().getItem(x).setEnabled(true);
                                        }
                                    }
                                }

                            }
                        });

                    first_run="not";
                    db.updateRefreshTime();
            }
        }
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout, new fragment_home()).commit();

        for (int x = 0; x < bottomNavigationview.getMenu().size(); x++) {
            bottomNavigationview.getMenu().getItem(x).setEnabled(true);
        }

        if(MainActivity.null_data==false){
            db.checkLocalDataIntegrity();
        }
        //bottom nav
        BottomNavigationView btnNav = findViewById(R.id.bottomNavigationview);
        btnNav.setOnNavigationItemSelectedListener(navListener);

        //setting home fragment as main fragment
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout,new fragment_home()).commit();

    }

    //listener nav bar
    public BottomNavigationView.OnNavigationItemSelectedListener navListener = new
            BottomNavigationView.OnNavigationItemSelectedListener() {
                @Override
                public boolean onNavigationItemSelected(@NonNull MenuItem item) {

                    switch (item.getItemId()){
                        case R.id.home:
                            selectedFragment = new fragment_home();
                            break;

                        case R.id.fav:
                            selectedFragment = new fragment_fav();
                            break;

                        case R.id.aboutus:
                            selectedFragment = new fragment_aboutus();
                            break;
                    }

                    //begin transaction
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_layout
                                    ,selectedFragment).commit();
                    return true;
                }
            };

}