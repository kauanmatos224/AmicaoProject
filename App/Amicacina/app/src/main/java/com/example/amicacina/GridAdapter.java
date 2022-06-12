package com.example.amicacina;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import java.util.ArrayList;

public class GridAdapter extends ArrayAdapter<GridModel> {
    public GridAdapter(@NonNull Context context, ArrayList<GridModel> gridModelArrayList) {
        super(context, 0, gridModelArrayList);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        View listitemView = convertView;
        if (listitemView == null) {
            // Layout Inflater inflates each item to be displayed in GridView.
            listitemView = LayoutInflater.from(getContext()).inflate(R.layout.card_item, parent, false);
        }
        GridModel gridModel = getItem(position);
        //TextView nameTV = listitemView.findViewById(R.id.idTVname);
        ImageView petIV = listitemView.findViewById(R.id.GVimg);
        //nameTV.setText(gridModel.getpet_name());
        petIV.setImageResource(gridModel.getImgid());
        return listitemView;
    }
}
